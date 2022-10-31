<?php

namespace App\Http\Controllers;

use Composer\Autoload\ClassLoader;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\Area;
use App\Models\Company;
use App\Models\Device;
use App\Models\PurposeDevice;
use App\Models\EmployeeProject;
use App\Models\Project;
use App\Models\ProjectLocation;
use App\Models\Purpose;
use App\Models\Supplier;
use App\Models\Tools;
use App\Models\User;
use App\Models\VisitorType;
use App\Models\Visitor;
use App\Models\VisitorProject;
use App\Models\VisitorProjectDevice;
use DB;
use Mail;

class ProjectApprovedController extends Controller
{
    public function index(Request $request, $id_project, $id_project_location)
    {
        $project= Project::find($id_project);
        $project_approved_status = $project->status;
        $projectLocation = ProjectLocation::find($id_project_location);
        $is_need_nda = $projectLocation->is_need_nda;
        $data = compact('project', 'projectLocation', 'id_project', 'id_project_location', 'project_approved_status', 'is_need_nda');
        if ($project_approved_status == 1) {
            $data = $this->indexVisitorForm($request, $id_project, $id_project_location);
        } else if ($project_approved_status == 2){
            $data = $this->indexNDAForm($request, $id_project, $id_project_location);
        }

        // dd($project);

        return view('ProjectApproved.index', $data);
    }

    public function updateVisitorForm(Request $request, $id_project, $id_project_location) {
        //dd($request->all());
        //dd($request->all());
        $projectLocation = ProjectLocation::find($id_project_location);
        $is_need_nda = $projectLocation->is_need_nda;

        $project = Project::find($id_project);
        $project->company_name = $request->input('company_name');
        $project->id_supplier = $request->input('supplier_type');
        $project->id_visitor_type = $request->input('visitor_type');
        $project->id_purpose = $request->input('visit_purpose');
        $project->status = $is_need_nda ? 2 : 4;

        /**
         * Save to table company
         */
        // $company = Company::where('name', $request->input('company_name'))->first();
        // if ($company) {
        //     $project->id_company = $company->id;
        // } else {
        $comname = DB::select('SELECT company_name FROM project where id="'.$id_project.'"');
        // dd($comname[0]->company_name);
        if($project->id_company == null){
            $company = new Company;
            // $company->name = $request->input('company_name');
            $company->name = $comname[0]->company_name;
            // $company->email = $request->input('company_email');
            $company->address = $request->input('company_address');
            $company->phone = $request->input('company_phone');
            $company->save();
            $project->id_company = $company->id;
        }else{
            $company = Company::find($project->id_company);
            // $company->name = $request->input('company_name');
            $company->name = $comname[0]->company_name;
            // $company->email = $request->input('company_email');
            $company->address = $request->input('company_address');
            $company->phone = $request->input('company_phone');
            $company->save();
        }
        if($project->type == 1){
            $projectLocationAdd = ProjectLocation::find($id_project_location);
            $projectLocationAdd->date_start = $request->date_start." 00:00:00";
            $projectLocationAdd->date_end = $request->date_end." 00:00:00";
            $projectLocationAdd->time_start = $request->date_start." ".$request->time_start.":00";
            $projectLocationAdd->time_end = $request->date_end." ".$request->time_end.":00";
            // dd($projectLocationAdd->date_start, $projectLocationAdd->date_end, $projectLocationAdd->time_start, $projectLocationAdd->time_end);
            $projectLocationAdd->save();

        }

        // }

        /**
         * Save to table visitor
         */
        // $now = date('Y-m-d H:i:00');
        $members = [];
        foreach ($request->input('members_id') as $key => $member_id) {
            $members[$key]['id'] = $member_id;
        }
        foreach ($request->input('members_name') as $key => $member_name) {
            $members[$key]['name'] = $member_name;
            $members[$key]['id_company'] = $company->id;
            $members[$key]['created_at'] = date('Y-m-d H:i:00');
            $members[$key]['updated_at'] = date('Y-m-d H:i:00');
        }
        foreach ($request->input('members_ktp') as $key => $member_ktp) {
            $members[$key]['ktp'] = $member_ktp;
        }
        foreach ($request->input('members_email') as $key => $members_email) {
            $members[$key]['email'] = $members_email;
        }
        Visitor::insertOrIgnore($members);
        Visitor::upsert([
            [   'id' => $request->input('leader_id'),
                'name' => $request->input('leader_name'),
                'ktp' => $request->input('identity_card_number'),
                'email' => $request->input('leader_email'),
                'id_company' => $company->id
            ]
        ],
            [
                ['id'],['name','ktp','email']
            ]
        );

        /**
         * Save to table user
         */
        $users = [];
        foreach ($request->input('employee_name') as $key => $employee_name) {
            $users[$key]['name'] = $employee_name;
        }
        User::insertOrIgnore($users);
        $project->save();

        /**
         * Save to table visitor_project for members
         */
        VisitorProject::where('id_project', $id_project)->delete();
        $visitorLead = Visitor::where('ktp', $request->input('identity_card_number'))->where('id_company', $company->id)->first();
        $visitorProject = new VisitorProject;
        $visitorProject->id_project = $id_project;
        $visitorProject->id_visitor = $visitorLead->id;
        $visitorProject->level = 1;
        $visitorProject->save();

        $visitors = Visitor::whereIn('ktp', $request->input('members_ktp'))->where('id_company', $company->id)->get();
        foreach ($visitors as $key => $value) {
            $visitorProject = new VisitorProject;
            $visitorProject->id_project = $id_project;
            $visitorProject->id_visitor = $value->id;
            $visitorProject->level = 2;
            $visitorProject->save();
        }

        /**
         * Save to table employee_project for PIC Project from YKK
         */
        EmployeeProject::where('id_project', $id_project)->delete();
        $employee = User::whereIn('name', $request->input('employee_name'))->get();
        foreach ($employee as $key => $value) {
            $employeeProject = new EmployeeProject;
            $employeeProject->id_project = $id_project;
            $employeeProject->id_user = $value->id;
            $employeeProject->save();
        }

        return redirect('project-approved/'.$id_project.'/'.$id_project_location);

    }

    protected function indexVisitorForm(Request $request, $id_project, $id_project_location) {
        $project= Project::find($id_project);
        $project_approved_status = $project->status;

        $projectLocation = ProjectLocation::find($id_project_location);
        $is_need_nda = $projectLocation->is_need_nda;

        $visitor_types = VisitorType::all();
        $purposes = Purpose::where('category', '1')->get();
        $companies = Company::all();
        $suppliers = Supplier::all();

        $users = Auth::user();

        $data = compact(
            'id_project',
            'id_project_location',
            'projectLocation',
            'users',
            'project',
            'project_approved_status',
            'is_need_nda',
            'visitor_types',
            'purposes',
            'companies',
            'suppliers',
        );

        return $data;
    }

    protected function indexNDAForm(Request $request, $id_project, $id_project_location) {
        $restricted_areas = Area::where('cat_confidential', 2)->get();
        $strictly_restricted_areas = Area::where('cat_confidential', 3)->get();

        $project = Project::find($id_project);
        $project_approved_status = $project->status;
        $purposes = Purpose::where('category', '2')->get();

        $projectLocation = ProjectLocation::find($id_project_location);
        $is_need_nda = $projectLocation->is_need_nda;
        $devices = Device::all();
        $purdevices = PurposeDevice::all();
        $data = compact(
            'id_project',
            'id_project_location',
            'project',
            'purposes',
            'projectLocation',
            'project_approved_status',
            'is_need_nda',
            'restricted_areas',
            'strictly_restricted_areas',
            'devices',
            'purdevices'
        );
        return $data;
    }

    public function updateNDAForm(Request $request, $id_project, $id_project_location) {
        ProjectLocation::where('id_project', $id_project)->where('is_input_by_ykk', 0)->delete();

        /**
         * Insert into table project_location - restricted_area
         */
        foreach ($request->input('restricted_area') as $key => $value) {
            $area = Area::find($value);
            if ($value != -1 || !$area) continue;
            $project_location = new ProjectLocation;
            $project_location->id_site = $area->id_site;
            $project_location->id_location = $area->id_location;
            $project_location->id_area = $value;
            $project_location->id_purpose = $request->input('restricted_area_purpose')[$key];
            $project_location->id_project = $id_project;
            $project_location->cat_confidence_area = 2;
            $project_location->is_input_by_ykk = 0;
            $project_location->save();
        }

        /**
         * Insert into table project_location - strictly restricted_area
         */
        foreach ($request->input('strictly_restricted_area') as $key => $value) {
            $area = Area::find($value);
            if ($value != -1 || !$area) continue;
            $project_location = new ProjectLocation;
            $project_location->id_site = $area->id_site;
            $project_location->id_location = $area->id_location;
            $project_location->id_area = $value;
            $project_location->id_purpose = $request->input('strictly_restricted_area_purpose')[$key];
            $project_location->id_project = $id_project;
            $project_location->cat_confidence_area = 3;
            $project_location->is_input_by_ykk = 0;
            $project_location->save();
        }

        /**
         * Insert into table visitor_project_devices
         */
        // dd($request);
        foreach ($request->input('device_id') as $key => $value) {
            VisitorProjectDevice::where('id_visitor_project', $request->input('visitor_project_id')[$key])->where('id_device', $request->input('device_id')[$key])->delete();
            $vProjectDevice = new VisitorProjectDevice;
            $vProjectDevice->id_visitor_project = $request->input('visitor_project_id')[$key];
            $vProjectDevice->id_device = $request->input('device_id')[$key];
            $vProjectDevice->id_purpose = $request->input('purpose_device_id')[$key];
            $vProjectDevice->qty = $request->input('device_qty')[$key];
            $vProjectDevice->save();
        }

        $project = Project::find($id_project);
        $project->status = 3;
        $project->save();

        // kirim email
        $pic = DB::select('SELECT
                visitor_email
            FROM
                project
            WHERE
                id = "'.$id_project.'"
        ');

        $pic_array = [];
        foreach ($pic as $_picData) {
            array_push($pic_array, $_picData->visitor_email);
        };

        $datas = Project::where('id', $id_project)->get();

        $idCom = DB::select('SELECT id_company AS id FROM project where id = "'.$id_project.'"');
        $visitID = str_pad( $idCom[0]->id, 4, "0", STR_PAD_LEFT );

        $mail_data['to'] = $pic_array;
        Mail::send('Mail._visitorCopleteFillForm', compact('datas', 'visitID'), function ($message) use ($mail_data) {
            $message->to($mail_data['to'])
                ->subject('Visitor System Response');
        });
        // end of kirim email
        return redirect('project-approved/'.$id_project.'/'.$id_project_location);
    }
}
