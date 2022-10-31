<?php

namespace App\Http\Controllers;

use App\Models\EmployeeProject;
use App\Models\Project;
use App\Models\ProjectLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use Mail;



class PurchasingController extends Controller
{
    public function index()
    {
        return view('Purchasing.index');

    }

    public function addPurchasing()
    {

        return view('Purchasing._add');
    }

    public function autocomplete(Request $request) {
        $response = [];
        return response()->json($response);
    }

    public function emailTemplate()
    {

        return view('Mail._FormFillRequest');
    }

    public function getAllPurchasing(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Project::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Project::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        $projects = DB::table('project')->
        leftjoin('supplier', 'project.id_supplier', '=', 'supplier.id')->
        leftjoin('visitor_type', 'project.id_visitor_type', '=', 'visitor_type.id')->
        leftjoin('purpose', 'project.id_purpose', '=', 'purpose.id')->
        leftjoin('project_location', 'project_location.id_project', '=', 'project.id')->
        leftjoin('employee_project', 'employee_project.id_project', '=', 'project.id')->
        join('users', 'users.id', '=', 'employee_project.id_user')->
        select('project.id','project.id_company', 'project.id_supplier','supplier.name as supplier_name','project.id_visitor_type','visitor_type.name as visitor_type_name', 'project.id_purpose','purpose.name as purpose_name', 'project.name', 'project.type', 'project.status', 'project.is_finish', 'project.is_rejected', 'project.reason','project_location.date_start','project_location.date_end','project_location.time_start','project_location.time_end', 'users.name as employee_name')->
        //orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('employee_project.level', '=', '1')->
        orWhere('employee_project.level', '=', null)->
        orWhere('project_location.is_input_by_ykk', '=', '1')->
        get()->unique('id');
        //dd($projects);
        $data_arr = array();
        $sno = $start+1;
        foreach($projects as $project){
            $display_progress = ["On Submit Visitor","On Submit Visitor","Waiting NDA Approval", "Waiting Factory Director Approval", "Waiting Safety Approval",'Done Approval'];
            $display_progress_rejected = ["On Re-Submit Visitor","On Re-Submit Visitor","Rejected NDA ", "Rejected HSE ", "Rejected Safety",'Done Approval'];
            $type_visitor = ["Visitor Normal","Vendor/Contractor","Visitor Special"];
            $data_arr[] = array(
                "id" => $project->id,
                "date" => array(
                    "date_start" => $project->date_start,
                    "date_end" => $project->date_end
                ),
                "time" => array(
                    "time_start" => $project->time_start,
                    "time_end" => $project->time_end
                ),
                "type" =>array(
                    "display" =>$type_visitor[$project->type-1],
                    "type" =>$project->type
                ),
                "visitor_coordinator" => $project->employee_name,
                "purpose" => $project->purpose_name,
                "project_detail" => $project->name,
                "progress" => array(
                    "display_not_rejected" => $display_progress[$project->status-1],
                    "display_rejected" => $display_progress_rejected[$project->status-1],
                    "status" => $project->status,
                    "is_rejected" =>$project->is_rejected
                ),
                "reason" => $project->is_rejected == 0 ? "-": $project->reason,
                "findings"=>"-",
                "status" => $project->is_finish == 0 ? "On Progress" : "Finish",
                "action"=> array(
                    "status" => $project->status,
                    "id" => $project->id,
                    "is_finish" =>$project->is_finish
                )
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        //return view('User.index', compact('users'));
        echo json_encode($response);
        exit;
    }

    public function getProjectDetail(Request $request){
        $id_project = $request->id;

        $project = Project::with('company','supplier','purpose','visitor_type','employee_project.employee','location_project.area', 'location_project.location','location_project.site','location_project.purpose','visitor_project.visitor_project_device.device','visitor_project.visitor_project_device.purpose', 'visitor_project.visitor' )->where('id',$id_project)->first()->toArray();
        //$project = Project::find($id_project);
        $employee_PIC= array();
        $employee_to_meet= array();
        foreach ($project['employee_project'] as $val){
            if($val['level'] == 1){
                $employee_PIC[] = $val;
            }else{
                $employee_to_meet[] = $val;
            }
        }

        $visitor_PIC = [];
        $visitor_member = [];
        foreach ($project['visitor_project'] as $val){
            if($val['level'] == 1){
                $visitor_PIC[] = $val;
            }else{
                $visitor_member[] = $val;
            }
        }


        $location_meet = [];
        $location_strictly = [];
        $location_restricted = [];

        foreach ($project['location_project'] as $val){
            if($val['is_input_by_ykk'] == 1){
                $location_meet[] = $val;
            }else{
                if($val['cat_confidential_area'] == 2){
                    $location_strictly[] = $val;
                }else if($val['cat_confidential_area'] == 3){
                    $location_restricted[] = $val;
                }
            }
        }
        //dd($location_restricted);
        return view('Project.index', compact('project','employee_PIC', 'employee_to_meet','visitor_PIC','visitor_member','location_meet', 'location_strictly', 'location_restricted'));
    }

    public function storePurchasing(Request $request)
    {

        $rules = [
            'name'                  => 'required|unique:project,name|min:3|max:50',
            'name_company'          => 'required|min:3|max:50',
            'id_site'               => 'required',
            'id_location'           => 'required',
            'id_area'               => 'required',
            'date_start'            => 'required',
            'time_start'            => 'required',
            'time_end'              => 'required',
            'type'                  => 'required',
            'visitor_email'         => 'required'
        ];

        $messages = [
            'name.required'                     => 'Project name is required',
            'name.min'                          => 'Project name of at least 3 characters',
            'name.max'                          => 'Project name up to 50 characters',
            'name.unique'                       => 'Project name has already exist',
            'name_company.required'             => 'Company name is required',
            'name_company.min'                  => 'Company name of at least 3 characters',
            'name_company.max'                  => 'Company name up to 50 characters',
            'date_start.required'               => 'Fill Date',
            'time_start.required'               => 'Fill Time Start',
            'time_end.required'                 => 'Fill Time End',
            'type.required'                     => 'Select Form Type',
            'visitor_email.required'            => 'Fill Email Sent To'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        $location = DB::select("SELECT
                is_need_nda
            FROM
                locations WHERE locations.id = ".$request->id_location."
        ");

        $area = DB::select("SELECT
                risk_not_work, cat_confidential
            FROM
                areas WHERE areas.id = ".$request->id_area."
        ");

        $project = new Project();
        $project->name = $request->name;
        $project->id_company = ($request->id_company != $request->name_company ?  $request->id_company : 'null');
        $project->company_name = $request->name_company;
        $project->visitor_email = ucwords(strtolower($request->visitor_email));
        $project->type = ucwords(strtolower($request->type));
        $project->expired_time = date('Y-m-d H:i:s', strtotime('30 minute'));
        $project->status = 1;
        $project->is_rejected = 0;
        $saveProject = $project->save();
        if ($saveProject) {
            $projectLocation = new ProjectLocation();
            $projectLocation->id_project = $project->id;
            $projectLocation->id_site = $request->id_site;
            $projectLocation->id_location = $request->id_location;
            $projectLocation->id_area = $request->id_area;
            if($project->type == 2){
                $projectLocation->date_start = $request->date_start." 00:00:00";
                $projectLocation->date_end = $request->date_end." 00:00:00";
            }else if($project->type == 3){
                $projectLocation->date_start = $request->date_start." 00:00:00";
                $projectLocation->date_end = $request->date_end." 00:00:00";
                $projectLocation->time_start = $request->date_start." ".$request->time_start.":00";
                $projectLocation->time_end = $request->date_start." ".$request->time_end.":00";
            }
            $projectLocation->is_working = 0;
            $projectLocation->cat_confidential_area = $area[0]->cat_confidential;
            $projectLocation->risk_category = $area[0]->risk_not_work;
            $projectLocation->is_need_nda = $location[0]->is_need_nda;

            $saveProject = $projectLocation->save();
            if($saveProject){
                $employeeProject = new EmployeeProject();
                $employeeProject->id_user = Auth::user()->id;
                $employeeProject->id_project = $project->id;
                $employeeProject->level = 1;
                $employeeProject->save();

                $email_data['to'] = $project->visitor_email;
                $emailTo = new \stdClass();
                $emailTo->company_name = $project->company_name;

                $link = "https://ykk.ofisdev.com/project-approved/".$project->id."/".$projectLocation->id;

                Mail::send('Mail._FormFillRequest', compact('emailTo', 'link'), function ($message) use ($email_data) {
                    $message->to($email_data['to'])
                        ->subject('Register Form');
                });
                Session::flash('success', 'Successfully added a new Project.');
                return redirect()->route('purchasing');
            }else{
                Session::flash('errors', ['' => 'Failed to add new area, Please try again later']);
                return redirect()->route('purchasing');
            }

        } else {
            Session::flash('errors', ['' => 'Failed to add new area, Please try again later']);
            return redirect()->route('purchasing');
        }
    }

    public function purchasingFinishProject($id)
    {
        Project::where('id', $id)->update(array('is_finish' => 1));
        Session::flash('success', 'Project has been successfully finish.');
        return redirect()->route('purchasing');
    }

    public function editArea($id)
    {
        $area = Area::find($id);
        $sites = DB::select("SELECT * FROM sites");
        $locations = DB::select("SELECT * FROM locations WHERE id_site = ".$area->id_site);
        return view('Area._edit', compact('area','sites', 'locations'));
    }

    public function updateArea(Request $request, $id)
    {
        $location = Area::find($id)->update($request->all());

        Session::flash('success', 'Area has been successfully updated.');
        return redirect()->route('areas');
    }

    public function deleteArea($id)
    {
        $result = DB::table('areas')->where('id', $id)->delete();

        if ($result) {
            $area['result'] = true;
            $area['message'] = "Area Successfully Deleted!";
        } else {
            $area['result'] = false;
            $area['message'] = "Area was not Deleted, Try Again!";
        }
        return json_encode($area, JSON_PRETTY_PRINT);
    }
}
