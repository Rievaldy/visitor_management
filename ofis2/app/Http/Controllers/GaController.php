<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Project;
use App\Models\VisitorVisit;
use Auth;

class GaController extends Controller
{
    public function index(){
        return view('GA.index');
    }

    public function getList(Request $request){
        $t0= $request->t0;
        $t1= $request->t1;

        $a = DB::select("SELECT
                a.id,
                a.id_company,
                b.name purpose,
                a.name `project_title`,
                a.company_name,
                a.type,
                a.status,
                c.date_start,
                c.date_end,
                c.time_start,
                c.time_end
            FROM
                project a
                    LEFT JOIN
                purpose b ON a.id_purpose = b.id
                    LEFT JOIN
                project_location c ON c.id_project = a.id
            WHERE
                id_company IS NOT NULL
                    and date_start >= '".$t0."' and date_end <= '".$t1."'
            ORDER BY time_start ASC
        ");
        return response()->json($a);
    }

    public function getDetails(Request $request){
        $id_project = $request->id;

        $project = Project::with('company','supplier','purpose','visitor_type','employee_project.employee','location_project.area', 'location_project.location','location_project.site','location_project.purpose','visitor_project.visitor_project_device.device','visitor_project.visitor_project_device.purpose', 'visitor_project.visitor', 'visitor_project.visitor_visit', 'visitor_project.visitor_visit.user')->where('id',$id_project)->first()->toArray();
        //$project = Project::find($id_project);
        $employee_PIC= array();
        $employee_to_meet= array();
        foreach ($project['employee_project'] as $val){
            // if($val['level'] == 1){
            //     $employee_PIC[] = $val;
            // }else{
            //     $employee_to_meet[] = $val;
            // }
            $employee_to_meet[] = $val;
            $employee_PIC= array();
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

        $visitor_device = [];
        foreach ($project['visitor_project'] as $val){
            $visitor_device[] = $val;
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
        // dd($project);
        //dd($location_restricted);
        return view('GA._view', compact('project','employee_PIC', 'employee_to_meet','visitor_PIC','visitor_member', 'visitor_device', 'location_meet', 'location_strictly', 'location_restricted'));
    }

    public function approve(Request $request){
        $app = new VisitorVisit;
        $app->id_visitor_project = $request->idvp;
        $app->is_approved = 1;
        $app->id_approved_by = Auth::user()->id;
        $app->approved_at = date("Y-m-d H:i:s");
        $save = $app->save();

        $data= DB::select('SELECT * FROM visitor_visit order by approved_at DESC limit 1');
        if($save){
            $res = array(
                'meta'=>[
                    'code' => 200,
                    'message' => 'Successfully added a new record.'
                ],
                'data'=> $data
            );
        } else {
            $res = array(
                'code' => 400,
                'message' => 'Failed to add new record, Please try again later.'
            );
        }
        return response()->json($res);
    }
}
