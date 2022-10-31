<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;
use DB;

class ProfileController extends Controller
{
    public function index()
    {
        $users = Auth::user();
        return view('Profile.index', compact('users'));
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'phone'=>'required',
        ]);

        $user = User::find(Auth::user()->id);
        $user->phone = $request->phone;

        if($request->password) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        Session::flash('success', 'Your profile has been successfully updated.');
        return redirect()->route('myProfile');
    }

    public function changePass()
    {
        $users = Auth::user();
        return view('Profile._changePass', compact('users'));
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        // dd($user);
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'new_confirm_password' => 'required|same:new_password'
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
                ])->save();

            Session::flash('success', 'Your profile has been successfully updated.');
            return redirect()->route('myProfile');

        } else {
            $request->session()->flash('error', 'Old password does not match');
            return redirect()->route('changePassword');
        }
    }

}
