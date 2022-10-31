<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Session;
use App\Models\Purpose;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class PurposeController extends Controller
{
    public function index()
    {

        $datas = DB::table('purpose')
            ->orderBy('purpose.created_at', 'ASC')
            ->get();
        return view('Purpose.index', compact('datas'));
    }

    public function addPurpose()
    {
        return view('Purpose._add');
    }

    public function storePurpose(Request $request)
    {
        $rules = [
            'name'                  => 'required|unique:purpose,name|min:3|max:50',
        ];

        $messages = [
            'name.required'         => 'Purpose Category name is required',
            'name.min'              => 'Purpose Category name of at least 3 characters',
            'name.max'              => 'Purpose Category name up to 50 characters',
            'name.unique'           => 'Purpose Category name has already exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $purpose = new Purpose;
        $purpose->name = ucwords(strtolower($request->name));
        $purpose->description = ($request->description);
        $purpose->category = ($request->category);
        $save = $purpose->save();

        if ($save) {
            Session::flash('success', 'Successfully added a new Purpose Category.');
            return redirect()->route('purpose');
        } else {
            Session::flash('errors', ['' => 'Failed to add new Purpose Category, Please try again later']);
            return redirect()->route('purpose');
        }
    }

    public function editPurpose($id)
    {
        $purpose = Purpose::find($id);
        return view('Purpose._edit', compact('purpose'));
    }

    public function updatePurpose(Request $request, $id)
    {
        $purpose = Purpose::find($id)->update($request->all());

        Session::flash('success', 'Purpose Category has been successfully updated.');
        return redirect()->route('purpose');
    }

    public function deletePurpose($id)
    {
        $delete = DB::table('purpose')->where('id', $id)->delete();

        Session::flash('success', 'Purpose Category has been successfully deleted.');
        return redirect()->route('purpose');
    }
}
