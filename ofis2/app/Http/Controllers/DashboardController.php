<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LockerLog;
use App\Models\Attendance;
use Illuminate\Support\Facades\Response;
use DB;
use Carbon\Carbon;
use DateTime;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }

}
