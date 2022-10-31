<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

use Validator;
use Session;
use App\Models\Location;
use App\Models\Report_dashboard;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class LocationController extends Controller
{
    public function index()
    {
        return view('Location.index');
    }

    public function addLocation()
    {

        return view('Location._add');
    }

    public function getAllLocations(Request $request){
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
        $totalRecords = Location::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Location::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        $locations = DB::table('locations')->
        join('sites', 'sites.id', '=', 'locations.id_site')->
        select('locations.id', 'locations.name as location_name', 'locations.is_production_area', 'locations.is_need_nda', 'sites.name as site_name', 'locations.updated_at')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('locations.name', 'like', '%' .$searchValue . '%')->
        orWhere('sites.name', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($locations as $location){
            $data_arr[] = array(
                "id" => $location->id,
                "location_name" =>$location->location_name,
                "site_name" => $location->site_name,
                "is_production_area" => array(
                    "display" => $location->is_production_area == 0 ?'Non Production Area' : 'Production Area',
                    "is_production_area" => $location->is_production_area
                ),
                "is_need_nda" => array(
                    "display" => $location->is_need_nda == 0 ?'NO' : 'YES',
                    "is_need_nda" => $location->is_need_nda
                ),
                "updated_at" => $location->updated_at
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

    public function getLocationById(Request $request){

        $id = $request->id;
        $locations = DB::table('locations')->
        join('sites', 'sites.id', '=', 'locations.id_site')->
        select('locations.id', 'locations.name as location_name', 'locations.is_production_area', 'locations.is_need_nda', 'sites.name as site_name', 'locations.updated_at')->
        where('locations.id', '=', $id)->get();
        //dd($user);
        $response = array(
            "id" => $locations[0]->id,
            "location_name" =>$locations[0]->location_name,
            "site_name" => $locations[0]->site_name,
            "is_production_area" => array(
                "display" => $locations[0]->is_production_area == 0 ?'Non Production Area' : 'Production Area',
                "is_production_area" => $locations[0]->is_production_area
            ),
            "is_need_nda" => array(
                "display" => $locations[0]->is_need_nda == 0 ?'NO' : 'YES',
                "is_production_area" => $locations[0]->is_need_nda
            ),
            "updated_at" => $locations[0]->updated_at
        );
        return response()->json($response);
    }

    public function getLocationSelect2(Request $request){
        $id = $request->id;
        $list = DB::select("SELECT
                id AS id, name AS text
            FROM
                locations WHERE locations.id_site = '".$id."'
        ");
        return response()->json($list);
    }

    public function storeLocation(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:locations,name|min:3|max:100',
            'is_production_area'    => 'required',
            'is_need_nda'           => 'required',
            'id_site'               => 'required'
        ];

        $messages = [
            'name.required'                     => 'Location name is required',
            'name.min'                          => 'Location name of at least 3 characters',
            'name.max'                          => 'Location name up to 100 characters',
            'name.unique'                       => 'Location name has already exist',
            'id_site.required'                  => 'Please Choose Site Category',
            'is_production_area.required'       => 'Select Production Category',
            'is_need_nda.required'              => 'Select NDA Location Requirement'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $location = new Location;
        $location->id_site = ucwords(strtolower($request->id_site));
        $location->name = ucwords(strtolower($request->name));
        $location->is_production_area = ($request->is_production_area);
        $location->is_need_nda = ($request->is_need_nda);
        $save = $location->save();

//        $user = Auth::user()->id;
//        $pesan = 'Added Location';
//
//        // Store report dashboard
//        if ($save == true) {
//            $dashboard = new Report_dashboard;
//            $dashboard->user_id = $user;
//            $dashboard->action = $pesan;
//            $saves = $dashboard->save();
//        }

        if ($save) {
            Session::flash('success', 'Successfully added a new location.');
            return redirect()->route('locations');
        } else {
            Session::flash('errors', ['' => 'Failed to add new location, Please try again later']);
            return redirect()->route('locations');
        }
    }

    public function editLocation($id)
    {
        $location = Location::find($id);
        $sites = DB::select("SELECT * FROM sites");
        return view('Location._edit', compact('location','sites'));
    }

    public function updateLocation(Request $request, $id)
    {
        $location = Location::find($id)->update($request->all());

        Session::flash('success', 'Location has been successfully updated.');
        return redirect()->route('locations');
    }

    public function deleteLocation($id)
    {
        $result = DB::table('locations')->where('id', $id)->delete();

        if ($result) {
            $user['result'] = true;
            $user['message'] = "Locations Successfully Deleted!";
        } else {
            $user['result'] = false;
            $user['message'] = "Locations was not Deleted, Try Again!";
        }
        return json_encode($user, JSON_PRETTY_PRINT);
    }
}
