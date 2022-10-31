<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\Tools;
use Illuminate\Http\Request;
use Validator;
use Session;
use DB;
use Mail;
use View;

class ToolsController extends Controller
{
    public function index()
    {

        $datas = DB::table('tools')
            ->orderBy('tools.created_at', 'ASC')
            ->get();
        return view('Tool.index', compact('datas'));
    }

    public function getAllTools(Request $request){
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
        $totalRecords = Tools::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Tools::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->
        orWhere('tools.description', 'like', '%' .$searchValue . '%')->count();

        $tools = DB::table('tools')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('tools.name', 'like', '%' .$searchValue . '%')->
        orWhere('tools.description', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($tools as $tool){
            $data_arr[] = array(
                "id" => $tool->id,
                "name" =>$tool->name,
                "description" =>$tool->description,
                "updated_at" =>$tool->updated_at
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

    public function getToolById(Request $request){

        $id = $request->id;
        $tools = DB::table('tools')->
        where('tools.id', $id)->get();
        //dd($user);
        $response = array(
            "id" =>$tools[0]->id,
            "name" =>$tools[0]->name,
            "description" => $tools[0]->description,
            "img" => $tools[0] ->img
        );
        return response()->json($response);
    }

    public function getToolsSelect2(){
        $list = DB::select("SELECT
                id AS id, name AS text
            FROM
                tools
        ");
        return response()->json($list);
    }

    public function addTool()
    {
        return view('Tool._add');
    }

    public function storeTool(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:tools,name|min:3|max:50',
            'img'                   => 'required',
        ];

        $messages = [
            'name.required'         => 'Tool Category name is required',
            'name.min'              => 'Tool Category name of at least 3 characters',
            'name.max'              => 'Tool Category name up to 50 characters',
            'name.unique'           => 'Tool Category name has already exist',
            'img.required'          => 'Tools Image required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $tools = new Tools();
        $tools->name = ucwords(strtolower($request->name));
        $tools->description = ($request->description);
        $tools->img = 'data:image/png;base64,' . base64_encode(file_get_contents($request->file('img')));
        $save = $tools->save();

        if ($save) {
            Session::flash('success', 'Successfully added a new tools category.');
            return redirect()->route('tools');
        } else {
            Session::flash('errors', ['' => 'Failed to add new tools category, Please try again later']);
            return redirect()->route('tools');
        }
    }

    public function editTool($id)
    {
        $tool = Tools::find($id);
        return view('Tool._edit', compact('tool'));
    }

    public function updateTool(Request $request, $id)
    {
        $tool = Tools::find($id);
        $tool->name = $request->name;
        $tool->description = $request->description;

        if ($request->img) {
            $tool->img = 'data:image/png;base64,' . base64_encode(file_get_contents($request->img));
        }
        $tool->save();

        Session::flash('success', 'Tool Category has been successfully updated.');
        return redirect()->route('tools');
    }

    public function deleteTool($id)
    {
        $result = DB::table('tools')->where('id', $id)->delete();

        if ($result) {
            $user['result'] = true;
            $user['message'] = "Tools Successfully Deleted!";
        } else {
            $user['result'] = false;
            $user['message'] = "Tools was not Deleted, Try Again!";
        }
        return json_encode($user, JSON_PRETTY_PRINT);
    }
}
