<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{

//    public function getProjectById(Request $request){
//
//        $id = $request->id;
//        $project = DB::table('project')->
//        where('locations.id', '=', $id)->get();
//        //dd($user);
//        $response = array(
//            "id" => $locations[0]->id,
//            "location_name" =>$locations[0]->location_name,
//            "site_name" => $locations[0]->site_name,
//            "is_production_area" => array(
//                "display" => $locations[0]->is_production_area == 0 ?'Non Production Area' : 'Production Area',
//                "is_production_area" => $locations[0]->is_production_area
//            ),
//            "is_need_nda" => array(
//                "display" => $locations[0]->is_need_nda == 0 ?'NO' : 'YES',
//                "is_production_area" => $locations[0]->is_need_nda
//            ),
//            "updated_at" => $locations[0]->updated_at
//        );
//        return response()->json($response);
//    }


    public function storeProject(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:locations,name|min:3|max:50',
            'type'                  => 'requred',
            'visitor_email'         => 'required',
            'status'                => 'required',
            'is_rejected'           => 'required',
        ];

        $messages = [
            'name.required'                     => 'Project name is required',
            'name.min'                          => 'Project name of at least 3 characters',
            'name.max'                          => 'Project name up to 50 characters',
            'name.unique'                       => 'Project name has already exist',
            'type.required'                     => 'Select Form Type',
            'status.required'                   => 'Fill Status',
            'is_rejected.required'              => 'Fill Reject Status'
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
