<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;

class SiteController extends Controller
{
    public function index()
    {
        $datas = DB::table('sites')
            ->orderBy('sites.created_at', 'ASC')
            ->get();
        return view('Site.index', compact('datas'));
    }

    public function getAllSite(Request $request){
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
        $totalRecords = Site::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Site::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->
        orWhere('sites.address', 'like', '%' .$searchValue . '%')->count();

        $sites = DB::table('sites')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('sites.name', 'like', '%' .$searchValue . '%')->
        orWhere('sites.address', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($sites as $site){
            $data_arr[] = array(
                "id" => $site->id,
                "name" =>$site->name,
                "address" =>$site->address,
                "updated_at" =>$site->updated_at
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

    public function getSiteSelect2(){
        $list = DB::select("SELECT
                id AS id, name AS text
            FROM
                sites
        ");
        return response()->json($list);
    }

    public function getSiteById(Request $request){
        $id = $request->id;
        $sites = DB::table('sites')->
        where('sites.id', $id)->get();
        //dd($user);
        $response = array(
            "id" =>$sites[0]->id,
            "name" =>$sites[0]->name,
            "address" => $sites[0]->address
        );
        return response()->json($response);
    }

    public function addSite()
    {
        return view('Site._add');
    }

    public function storeSite(Request $request)
    {
        $rules = [
            'name' => 'required|unique:sites,name|min:3|max:50',
        ];

        $messages = [
            'name.required'         => 'Site Category name is required',
            'name.min'              => 'Site Category name of at least 3 characters',
            'name.max'              => 'Site Category name up to 50 characters',
            'name.unique'           => 'Site Category name has already exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $site = new Site();
        $site->name = ucwords(strtolower($request->name));
        $site->address = ($request->address);
        $save = $site->save();

        if ($save) {
            Session::flash('success', 'Successfully added a new site category.');
            return redirect()->route('sites');
        } else {
            Session::flash('errors', ['' => 'Failed to add new site category, Please try again later']);
            return redirect()->route('sites');
        }
    }

    public function editSite($id)
    {
        $site = Site::find($id);

        return view('Site._edit', compact('site'));

    }

    public function updateSite(Request $request, $id)
    {
        Site::find($id)->update($request->all());

        Session::flash('success', 'Site Category has been successfully updated.');
        return redirect()->route('sites');
    }

    public function deleteSite($id)
    {
        $result = DB::table('sites')->where('id', $id)->delete();

        if ($result) {
            $user['result'] = true;
            $user['message'] = "Site Successfully Deleted!";
        } else {
            $user['result'] = false;
            $user['message'] = "Site was not Deleted, Try Again!";
        }
        return json_encode($user, JSON_PRETTY_PRINT);
    }
}
