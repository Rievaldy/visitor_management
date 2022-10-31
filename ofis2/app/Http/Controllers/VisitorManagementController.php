<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\Visitor;
use Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Mail;

class VisitorManagementController extends Controller
{
    public function index(Request $request){
        return view('VisitorManagement.index');
    }
}
