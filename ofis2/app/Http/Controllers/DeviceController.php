<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Session;
use App\Models\Device;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class DeviceController extends Controller
{
    public function index()
    {

        $datas = DB::table('devices')
            ->orderBy('devices.created_at', 'ASC')
            ->get();
        return view('Device.index', compact('datas'));
    }

    public function getAllDevice(Request $request){
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
        $totalRecords = Device::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Device::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->
        orWhere('devices.description', 'like', '%' .$searchValue . '%')->count();

        $devices = DB::table('devices')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('devices.name', 'like', '%' .$searchValue . '%')->
        orWhere('devices.description', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($devices as $device){
            $data_arr[] = array(
                "id" => $device->id,
                "name" =>$device->name,
                "description" =>$device->description,
                "updated_at" =>$device->updated_at
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

    public function getDeviceById(Request $request){

        $id = $request->id;
        $devices = DB::table('devices')->
        where('devices.id', $id)->get();
        //dd($user);
        $response = array(
            "id" =>$devices[0]->id,
            "name" =>$devices[0]->name,
            "description" => $devices[0]->description
        );
        return response()->json($response);
    }

    public function addDevice()
    {
        return view('Device._add');
    }

    public function storeDevice(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:devices,name|min:3|max:50',
        ];

        $messages = [
            'name.required'         => 'Device Category name is required',
            'name.min'              => 'Device Category name of at least 3 characters',
            'name.max'              => 'Device Category name up to 50 characters',
            'name.unique'           => 'Device Category name has already exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $devices = new Device;
        $devices->name = ucwords(strtolower($request->name));
        $devices->description = ($request->description);
        $save = $devices->save();

        if ($save) {
            Session::flash('success', 'Successfully added a new devices category.');
            return redirect()->route('device');
        } else {
            Session::flash('errors', ['' => 'Failed to add new devices category, Please try again later']);
            return redirect()->route('device');
        }
    }

    public function editDevice($id)
    {
        $device = Device::find($id);
        return view('Device._edit', compact('device'));
    }

    public function updateDevice(Request $request, $id)
    {
        $device = Device::find($id)->update($request->all());

        Session::flash('success', 'Device Category has been successfully updated.');
        return redirect()->route('device');
    }

    public function deleteDevice($id)
    {
        $result = DB::table('devices')->where('id', $id)->delete();

        if ($result) {
            $user['result'] = true;
            $user['message'] = "Device Successfully Deleted!";
        } else {
            $user['result'] = false;
            $user['message'] = "Device was not Deleted, Try Again!";
        }
        return json_encode($user, JSON_PRETTY_PRINT);
    }
}
