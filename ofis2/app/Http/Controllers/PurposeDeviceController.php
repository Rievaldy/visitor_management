<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\PurposeDevice;

class PurposeDeviceController extends Controller
{
    public function index(){
        return view('PurposeDevice.index');
    }
    public function getList(Request $request){
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
        $totalRecords = PurposeDevice::select('count(*) as allcount')->count();
        $totalRecordswithFilter = PurposeDevice::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = PurposeDevice::orderBy($columnName,$columnSortOrder)
        ->where('m_device_purpose.name', 'like', '%' .$searchValue . '%')
        ->select('m_device_purpose.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $desc = $record->desc;
            $status = $record->status;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "desc" => $desc,
                "status" => $status
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }
}
