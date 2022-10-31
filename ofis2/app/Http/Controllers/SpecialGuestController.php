<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use DB;
use Mail;
use App\Models\EmployeeProject;
use App\Models\Project;
use App\Models\ProjectLocation;
use App\Models\Company;

class SpecialGuestController extends Controller
{
    public function index(){
        $employee = DB::select('SELECT
                *
            FROM
                users
        ');

        $company = DB::select('SELECT id, name FROM company');
        // dd($company);
        return view('SpecialGuest.index', compact('employee', 'company'));
    }

    public function autocomplete(Request $request){
        $search = $request->cari;
        $company = DB::select("SELECT
                id,
                name
            FROM company
            WHERE name like '%".$search."%' LIMIT 5
        ");
        $nameCompany = [];
        foreach($company as $_company) {
            array_push($nameCompany,$_company->name);
        }

        $response = [];
        foreach($company as $_party){
            $response[] = array(
                "label" => $_party->name,
                "name" => $_party->name,
                "id" => $_party->id,
            );
        };

        // dd($response);
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:100',
            'name_company'          => 'required|min:3|max:100',
            'id_site'               => 'required',
            'id_location'           => 'required',
            'id_area'               => 'required',
            'date'                  => 'required',
            'time_start'            => 'required',
            'time_end'              => 'required',
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
            'date.required'                     => 'Fill Date',
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
        // $project->type = ucwords(strtolower($request->type));
        $project->type = 3;
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
            $projectLocation->date_start = $request->date." 00:00:00";
            $projectLocation->date_end = $request->date." 00:00:00";
            $projectLocation->time_start = $request->date." ".$request->time_start.":00";
            $projectLocation->time_end = $request->date." ".$request->time_end.":00";
            $projectLocation->is_working = 0;
            $projectLocation->cat_confidential_area = $area[0]->cat_confidential;
            $projectLocation->risk_category = $area[0]->risk_not_work;
            $projectLocation->is_need_nda = $location[0]->is_need_nda;

            $saveProject = $projectLocation->save();
            if($saveProject){
                $employeeProject = new EmployeeProject();
                // $employeeProject->id_user = Auth::user()->id;
                $employeeProject->id_user = $request->employee_id;
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
                Session::flash('success', 'Successfully added a new Project. For the next step please check your email.');
                return redirect()->route('spc.index');
            }else{
                Session::flash('errors', ['' => 'Failed to add new area, Please try again later']);
                return redirect()->route('spc.index');
            }

        } else {
            Session::flash('errors', ['' => 'Failed to add new area, Please try again later']);
            return redirect()->route('spc.index');
        }
    }
}
