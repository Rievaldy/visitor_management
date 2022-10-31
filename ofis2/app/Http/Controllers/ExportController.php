<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\VisitorExport;
use App\Exports\LockerExport;
use App\Exports\AttendanceOnlineExport;
use App\Exports\FnBExport;
use App\Exports\FrontdeskExport;
use App\Exports\SecretaryExport;
use App\Exports\MeetingParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportVisitor(){
        return Excel::download(new VisitorExport, 'Visitor_Reeport.xlsx');
    }
    public function exportLocker(){
        return Excel::download(new LockerExport, 'Locker_Report.xlsx');
    }
    public function attendanceOnlineExport(){
        return Excel::download(new AttendanceOnlineExport, 'Online_Attendance_Report.xlsx');
    }
    public function fnbExport(){
        return Excel::download(new FnBExport, 'FnB_Report.xlsx');
    }
    public function frontdeskExport(){
        return Excel::download(new FrontdeskExport, 'Frontdesk_Report.xlsx');
    }
    public function secretaryExport(){
        return Excel::download(new SecretaryExport, 'Secretary_Report.xlsx');
    }
    public function participantExport(){
        return Excel::download(new MeetingParticipantsExport, 'Meeting_Participant_Report.xlsx');
    }
}
