<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Session;
use App\Models\Supplier;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class SupplierController extends Controller
{
    public function index()
    {

        $datas = DB::table('supplier')
            ->orderBy('supplier.created_at', 'ASC')
            ->get();
        return view('Supplier.index', compact('datas'));
    }

    public function getAllSuppliers(Request $request){
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
        $totalRecords = Supplier::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Supplier::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->
        orWhere('supplier.description', 'like', '%' .$searchValue . '%')->count();

        $suppliers = DB::table('supplier')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('supplier.name', 'like', '%' .$searchValue . '%')->
        orWhere('supplier.description', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($suppliers as $supplier){
            $data_arr[] = array(
                "id" => $supplier->id,
                "name" =>$supplier->name,
                "description" =>$supplier->description,
                "updated_at" =>$supplier->updated_at
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

    public function getSupplierById(Request $request){

        $id = $request->id;
        $suppliers = DB::table('supplier')->
        where('supplier.id', $id)->get();

        $response = array(
            "id" =>$suppliers[0]->id,
            "name" =>$suppliers[0]->name,
            "description" => $suppliers[0]->description
        );
        return response()->json($response);
    }

    public function addSupplier()
    {
        return view('Supplier._add');
    }

    public function storeSupplier(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:supplier,name|min:3|max:50',
        ];

        $messages = [
            'name.required'         => 'Supplier name is required',
            'name.min'              => 'Supplier name of at least 3 characters',
            'name.max'              => 'Supplier name up to 50 characters',
            'name.unique'           => 'Supplier name has already exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $supplier = new Supplier;
        $supplier->name = ucwords(strtolower($request->name));
        $supplier->description = ($request->description);
        $save = $supplier->save();

        if ($save) {
            Session::flash('success', 'Successfully added a new Supplier List.');
            return redirect()->route('suppliers');
        } else {
            Session::flash('errors', ['' => 'Failed to add new Supplier List, Please try again later']);
            return redirect()->route('suppliers');
        }
    }

    public function editSupplier($id)
    {
        $suppliers = Supplier::find($id);
        return view('Supplier._edit', compact('suppliers'));
    }

    public function updateSupplier(Request $request, $id)
    {
        $rules = [
            'name'                  => 'required|min:3|max:50',
        ];

        $messages = [
            'name.required'         => 'Supplier name is required',
            'name.min'              => 'Supplier name of at least 3 characters',
            'name.max'              => 'Supplier name up to 50 characters'
        ];
        //dd($request->all());
        $validator = Validator::make($request->all(), $rules, $messages);

        //dd($request->except('_token'));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $supplier = Supplier::find($id)->update($request->except('_token'));
        if ($supplier) {
            Session::flash('success', 'Successfully edit Supplier List.');
            return redirect()->route('suppliers');
        } else {
            Session::flash('errors', ['' => 'Failed to edit Supplier List, Please try again later']);
            return redirect()->route('suppliers');
        }
    }


    public function deleteSupplier($id)
    {

        $result = DB::table('supplier')->where('id', $id)->delete();
        if ($result) {
            $supplier['result'] = true;
            $supplier['message'] = "Supplier Successfully Deleted!";
        } else {
            $supplier['result'] = false;
            $supplier['message'] = "Supplier was not Deleted, Try Again!";
        }
        return json_encode($supplier, JSON_PRETTY_PRINT);
    }
}
