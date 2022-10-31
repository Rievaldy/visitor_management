<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use Hash;
use App\Models\HighRiskTools;
use App\Models\CatHighRisk;
use Illuminate\Http\Request;
use Validator;
use Session;
use DB;
use Mail;
use View;

class HighRiskToolsController extends Controller
{
    public function index()
    {
        return view('HighRisk.index');
    }

    public function getAllHighRisk(Request $request){
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
        $totalRecords = CatHighRisk::select('count(*) as allcount')->count();
        $totalRecordswithFilter = CatHighRisk::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->
        orWhere('cat_high_risk.description', 'like', '%' .$searchValue . '%')->count();

        $highRisks = DB::table('cat_high_risk')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('cat_high_risk.name', 'like', '%' .$searchValue . '%')->
        orWhere('cat_high_risk.description', 'like', '%' .$searchValue . '%')->
        get();
        $data_arr = array();
        $sno = $start+1;
        foreach($highRisks as $highRisk){
            $tools_data = array();
            $highRiskTools = CatHighRisk::with('high_risk_tools.tools')->where('id','=', $highRisk->id)->first()->toArray();
            foreach ($highRiskTools['high_risk_tools'] as $highRiskTool){
                $tools_data[] = $highRiskTool['tools'];
            }
            $data_arr[] = array(
                "id" => $highRisk->id,
                "name" =>$highRisk->name,
                "description" =>$highRisk->description,
                "updated_at" =>$highRisk->updated_at,
                "tools" =>$tools_data
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

    public function getHighRiskById(Request $request){

        $id = $request->id;
        $highRisks = DB::table('cat_high_risk')->
        where('cat_high_risk.id', '=',$id)->get();
        $response = array();

        foreach($highRisks as $highRisk){
            $tools_data = array();
            //dd($highRisk->id);
            $highRiskTools = CatHighRisk::with('high_risk_tools')->where('id','=', $highRisk->id)->first()->toArray();
            foreach ($highRiskTools['high_risk_tools'] as $highRiskTool){
                $tool = DB::table('tools')->
                where('tools.id', $highRiskTool['id_tools'])->first();
                //dd($tool->id);
                $tool = array(
                    "id" =>$tool->id,
                    "name" =>$tool->name,
                    "description" => $tool->description,
                    "img" => $tool->img
                );
                $tools_data[] = $tool;
            }
            $response = array(
                "id" => $highRisk->id,
                "name" =>$highRisk->name,
                "description" =>$highRisk->description,
                "tools" =>$tools_data
            );
        }
        return response()->json($response);
    }

    public function getHighRiskSelect2(Request $request){
        $id = $request->id;
        $list = DB::select("SELECT
                id AS id, name AS text
            FROM
                cat_high_risk
        ");
        return response()->json($list);
    }

    public function addHighRisk()
    {
        $tools = Tools::all();
        return view('HighRisk._add', compact('tools'));
    }

    public function storeHighRisk(Request $request)
    {
        $tools = $request->tools;
//        dd($tools)
        $rules = [
            'name'                  => 'required|unique:cat_high_risk,name|min:3|max:50',
            'tools'                 => 'required',
        ];

        $messages = [
            'name.required'         => 'High Risk  name is required',
            'name.min'              => 'High Risk name of at least 3 characters',
            'name.max'              => 'High Risk name up to 50 characters',
            'name.unique'           => 'High Risk name has already exist',
            'tools.required'        => 'Tools required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $highRisk = new CatHighRisk();
        $highRisk->name = ucwords(strtolower($request->name));
        $highRisk->description = ($request->description);
        $saveHighRisk = $highRisk->save();

        if ($saveHighRisk) {
            for($i = 0; $i < count($tools); $i++){
                $highRiskTools = new HighRiskTools();
                $highRiskTools->id_tools = $tools[$i];
                $highRiskTools->id_cat_high_risk = $highRisk->id;
                $highRiskTools->save();
            }
            Session::flash('success', 'Successfully added a new High Risk category.');
            return redirect()->route('tools');
        } else {
            Session::flash('errors', ['' => 'Failed to add new High Risk category, Please try again later']);
            return redirect()->route('tools');
        }
    }

    public function editHighRisk($id)
    {
        $highRisk = CatHighRisk::find($id);
        $highRiskTools = HighRiskTools::where('id_cat_high_risk',$id)->get();
        $tools = Tools::all();
        return view('HighRisk._edit', compact('highRisk','highRiskTools','tools'));
    }

    public function updateHighRisk(Request $request, $id)
    {
        $tools = $request->tools;

        $highRisk = CatHighRisk::find($id);
        $highRisk->name = ucwords(strtolower($request->name));
        $highRisk->description = ($request->description);
        $saveHighRisk = $highRisk->save();
        $delete = DB::table('high_risk_tools')->where('id_cat_high_risk', $id)->delete();
        if ($saveHighRisk && $delete) {
            for($i = 0; $i < count($tools); $i++){
                $highRiskTools = new HighRiskTools();
                $highRiskTools->id_tools = $tools[$i];
                $highRiskTools->id_cat_high_risk = $highRisk->id;
                $highRiskTools->save();
            }
            Session::flash('success', 'Successfully edit a new High Risk category.');
            return redirect()->route('high-risk');
        } else {
            Session::flash('errors', ['' => 'Failed to edit new High Risk category, Please try again later']);
            return redirect()->route('high-risk');
        }
    }

    public function deleteHighRisk($id)
    {
        $result1 = DB::table('high_risk_tools')->where('id_cat_high_risk', $id)->delete();
        $result2 = DB::table('cat_high_risk')->where('id', $id)->delete();
        if ($result1 && $result2) {
            $user['result'] = true;
            $user['message'] = "High Risk Successfully Deleted!";
        } else {
            $user['result'] = false;
            $user['message'] = "High Risk was not Deleted, Try Again!";
        }
        return json_encode($user, JSON_PRETTY_PRINT);
    }
}
