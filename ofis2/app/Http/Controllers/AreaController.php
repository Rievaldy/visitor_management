<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

use Validator;
use Session;
use DB;
use App\Models\Area;
use App\Models\Location;
use App\Models\Report_dashboard;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class AreaController extends Controller
{
    public function index()
    {
        return view('Area.index');
    }

    public function addArea()
    {

        return view('Area._add');
    }

    public function getAllAreas(Request $request){
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
        $totalRecords = Area::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Area::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        $areas = DB::table('areas')->
        join('sites', 'sites.id', '=', 'areas.id_site')->
        join('locations', 'locations.id', '=', 'areas.id_location')->
        select('areas.id', 'areas.name as area_name', 'areas.cat_confidential', 'areas.risk_work', 'areas.risk_not_work', 'sites.name as site_name', 'locations.name as location_name', 'areas.updated_at')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('areas.name', 'like', '%' .$searchValue . '%')->
        orWhere('sites.name', 'like', '%' .$searchValue . '%')->
        orWhere('locations.name', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($areas as $area){
            if($area->cat_confidential == 1) $display_confidential = "No Restriction";
            if($area->cat_confidential == 2) $display_confidential = "Strictly Area";
            if($area->cat_confidential == 3) $display_confidential = "Restricted Area";
            $risk_category_translate = ["LOW","MEDIUM","HIGH"];
            $data_arr[] = array(
                "id" => $area->id,
                "area_name" =>$area->area_name,
                "location_name" =>$area->location_name,
                "site_name" => $area->site_name,
                "cat_confidential" => array(
                    "display" => $display_confidential,
                    "cat_confidential" => $area->cat_confidential
                ),
                "risk_work" => array(
                    "display" => $risk_category_translate[$area->risk_work-1],
                    "risk_work" => $area->risk_work
                ),
                "risk_not_work" => array(
                    "display" => $risk_category_translate[$area->risk_not_work-1],
                    "risk_not_work" => $area->risk_not_work
                ),
                "updated_at" => $area->updated_at
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

    public function getAreaById(Request $request){

        $id = $request->id;
        $areas = DB::table('areas')->
        join('sites', 'sites.id', '=', 'areas.id_site')->
        join('locations', 'locations.id', '=', 'areas.id_location')->
        select('areas.id', 'areas.name as area_name', 'areas.cat_confidential', 'areas.risk_work', 'areas.risk_not_work', 'sites.name as site_name', 'locations.name as location_name', 'areas.updated_at')->
        where('areas.id', '=', $id)->get();
        //dd($user);
        if($areas[0]->cat_confidential == 1) $display_confidential = "No Restriction";
        if($areas[0]->cat_confidential == 2) $display_confidential = "Restricted Area";
        if($areas[0]->cat_confidential == 3) $display_confidential = "Strictly Area";
        $risk_category_translate = ["LOW","MEDIUM","HIGH"];
        $response = array(
            "id" => $areas[0]->id,
            "area_name" =>$areas[0]->area_name,
            "location_name" =>$areas[0]->location_name,
            "site_name" => $areas[0]->site_name,
            "cat_confidential" => array(
                "display" => $display_confidential,
                "cat_confidential" => $areas[0]->cat_confidential
            ),
            "risk_work" => array(
                "display" => $risk_category_translate[$areas[0]->risk_work-1],
                "risk_work" => $areas[0]->risk_work
            ),
            "risk_not_work" => array(
                "display" => $risk_category_translate[$areas[0]->risk_not_work-1],
                "risk_not_work" => $areas[0]->risk_not_work
            ),
            "updated_at" => $areas[0]->updated_at
        );
        return response()->json($response);
    }

    public function getAreaSelect2(Request $request){
        $id = $request->id;
        $list = DB::select("SELECT
                id AS id, name AS text
            FROM
                areas WHERE areas.id_location = '".$id."'
        ");
        return response()->json($list);
    }

    public function storeArea(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:locations,name|min:3|max:50',
            'cat_confidential'      => 'required',
            'risk_work'             => 'required',
            'risk_not_work'         => 'required',
            'id_site'               => 'required',
            'id_location'           => 'required'
        ];

        $messages = [
            'name.required'                     => 'Area name is required',
            'name.min'                          => 'Area name of at least 3 characters',
            'name.max'                          => 'Area name up to 50 characters',
            'name.unique'                       => 'Area name has already exist',
            'id_site.required'                  => 'Please Choose Site Area',
            'id_location.required'              => 'Please Choose Location Area',
            'cat_confidential.required'         => 'Select Confidential Category'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $area = new Area;
        $area->id_site = ucwords(strtolower($request->id_site));
        $area->id_location = ucwords(strtolower($request->id_location));
        $area->name = ucwords(strtolower($request->name));
        $area->cat_confidential = ($request->cat_confidential);
        $area->risk_work = ($request->risk_work);
        $area->risk_not_work = ($request->risk_not_work);
        $save = $area->save();

        if ($save) {
            Session::flash('success', 'Successfully added a new area.');
            return redirect()->route('areas');
        } else {
            Session::flash('errors', ['' => 'Failed to add new area, Please try again later']);
            return redirect()->route('areas');
        }
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
