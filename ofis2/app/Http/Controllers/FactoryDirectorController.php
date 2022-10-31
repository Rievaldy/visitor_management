<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;

class FactoryDirectorController extends Controller
{
    public function index()
    {
        return view('FactoryDirector.index');

    }



    public function getAllFactoryDirector(Request $request){
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
        select('project.id','project.id_company', 'project.id_supplier','supplier.name as supplier_name','project.id_visitor_type','visitor_type.name as visitor_type_name', 'project.id_purpose','purpose.name as purpose_name', 'project.name', 'project.type', 'project.status', 'project.is_finish', 'project.is_rejected', 'project.reason','project_location.date_start','project_location.date_end','project_location.time_start','project_location.time_end')->
        //orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('project.status', '=', '4')->
        Where('project_location.is_input_by_ykk', '=', '1')->
        get()->unique('id');


        $data_arr = array();
        $sno = $start+1;
        $location_visit = [];
        foreach($projects as $project){
            $projectLocation = Project::with('location_project.area', 'location_project.location','location_project.site','location_project.purpose','visitor_project.visitor_project_device.device','visitor_project.visitor_project_device.purpose', 'visitor_project.visitor')->where('id',$project->id)->first()->toArray();
            foreach ($projectLocation['location_project'] as $val){
                if($val['is_input_by_ykk'] == 0){
                    if($val['cat_confidential_area'] == 2) {
                        $location_visit[] = $val;
                    }
                }
            }

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
                "id_company" => $project->id_company,
                "project_detail" => $project->name,
                "visitor_project" => $projectLocation['visitor_project'],
                "location_visit" => $location_visit,
                "number_worker" => sizeof($projectLocation['visitor_project']),
                "findings"=>"-"
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
        return view('FactoryDirector.detail-project', compact('project','employee_PIC', 'employee_to_meet','visitor_PIC','visitor_member','location_meet', 'location_strictly', 'location_restricted'));
    }

    public function factoryDirectorApproveProject($id)
    {
        $datas = DB::select('SELECT
                a.id_company,
                a.id AS idvis,
                a.name AS vname,
                a.email,
                c.name AS evname,
                c.company_name,
                c.type,
                d.date_start,
                d.date_end,
                d.time_start,
                d.time_end
            FROM
                visitor a
                    LEFT JOIN
                visitor_project b ON a.id = b.id_visitor
                    LEFT JOIN
                project c ON b.id_project = c.id
                LEFT JOIN
                    project_location AS d ON c.id = d.id_project
            WHERE
                b.id_project = "'.$id.'"
        ');
        // dd($datas);
        // $pic_array = [];
        // foreach ($pics as $_picData) {
        //     array_push($pic_array, $_picData->email);
        // };
        foreach ( $datas as $data ) {
            $mail_data['to'] = $data->email;
            Mail::send('Mail._visitorRequestApprove', compact('data'), function ($message) use ($mail_data) {
                $message->to($mail_data['to'])
                    ->subject('Your visit request has been approved');
            });
        }
        Project::where('id', $id)->update(array('status' => 6));

        Session::flash('success', 'Project has been successfully Approved.');
        // return redirect()->route('nda');
        return redirect()->route('FactoryDirector');
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
