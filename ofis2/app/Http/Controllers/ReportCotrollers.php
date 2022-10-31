<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportCotrollers extends Controller
{
    public function reportAttendance()
    {
        $date = date('Y-m-d 00:00:00');
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));
        $monthName = date("F", mktime(0, 0, 0, $month, 10));

        $datas = DB::select("SELECT DISTINCT
                mini.id,
                DATE_FORMAT(mini.date, '%b %d %Y') AS date,
                users.id AS userID,
                users.employee_id,
                users.name,
                masuk_time,
                masuk_status,
                masuk_fac_no,
                reasonsin,
                descriptionin,
                keluar_time,
                keluar_status,
                keluar_fac_no,
                reasonsout,
                descriptionout
            FROM
                users
                    INNER JOIN
                (SELECT DISTINCT
                    a.id,
                    a.date,
                    a.user_id,
                    a.name,
                    a.status AS masuk_status,
                    a.time AS masuk_time,
                    a.fac_no AS masuk_fac_no,
                    a.attendance_type,
                    a.reasons AS reasonsin,
                    a.description AS descriptionin
                FROM
                    attendance a
                JOIN (SELECT DISTINCT
                    id, date, user_id, MIN(time) AS time
                FROM
                    attendance
                WHERE status = 1 OR status = 9
                GROUP BY date , user_id) b ON a.time = b.time
                    AND a.user_id = b.user_id) mini ON mini.user_id = users.id
                    LEFT JOIN
                (SELECT DISTINCT
                    c.id,
                    c.date,
                    c.user_id,
                    c.name,
                    c.status AS keluar_status,
                    c.time AS keluar_time,
                    c.fac_no AS keluar_fac_no,
                    c.reasons AS reasonsout,
                    c.description AS descriptionout
                FROM
                    attendance c
                JOIN (SELECT
                    id, date, user_id, MAX(time) AS time
                FROM
                    attendance
                WHERE status = 2 OR status = 9
                GROUP BY date , user_id) d ON c.time = d.time
                    AND c.user_id = d.user_id) maxi ON maxi.user_id = users.id
                    AND maxi.date = mini.date
            -- WHERE
            --     MONTH(mini.date) = '" . $month . "' AND YEAR(mini.date) = '" . $year . "'
            -- GROUP BY users.id
            ORDER BY mini.date DESC , users.name ASC
        ");
        // dd($datas);
        return view('Report.attendance', compact('datas'));
    }
    public function reportAttendanceOnline()
    {
        $datas = DB::select("SELECT
                DATE_FORMAT(date, '%b %d %Y') AS date,
                name,
                employee_id,
                TIME(MIN(time)) AS checkin,
                TIME(MAX(time)) AS checkout,
                MIN(fac_no) AS fac_checkin,
                MAX(fac_no) AS fac_checkout
            FROM
                attendance
            WHERE attendance_type = 1
            GROUP BY date , name
            ORDER BY date DESC, name
        ");
        return view('Report.attendanceOnline', compact('datas'));
    }

    public function reportAttendanceOffline()
    {
        $datas = DB::select("SELECT
                DATE_FORMAT(date, '%b %d %Y') AS date,
                name,
                employee_id,
                TIME(MIN(time)) AS checkin,
                TIME(MAX(time)) AS checkout,
                MIN(fac_no) AS fac_checkin,
                MAX(fac_no) AS fac_checkout
            FROM
                attendance
            WHERE attendance_type = 2
            GROUP BY date , name
            ORDER BY date DESC, name
        ");
        return view('Report.attendanceOffline', compact('datas'));
    }

    public function reportVisitor()
    {
        $datas = DB::select("SELECT 
        visitors.id,
        visitors.name,
        visitors.phone,
        visitors.company,
        visitors.necessity,
        visitors.created_at,
        visitors.img,
        visitors.unix_id,
        users.id AS id_pic,
        users.name as name_pic
        FROM visitors INNER JOIN users
        ON visitors.pic_id = users.id
        ORDER BY visitors.created_at DESC, users.id DESC;");

        // dd($datas);
        return view('Report.visitor', compact('datas'));

        // $datas = DB::select("SELECT
        //         name, phone company, necessity, created_at
        //     FROM
        //         visitors
        //     ORDER BY created_at DESC
        // ");

    }
    public function viewReport($id)
    {
        $datas = DB::select("SELECT 
		visitors.id,
        visitors.name,
        visitors.phone,
        visitors.company,
        visitors.necessity,
        visitors.created_at,
        visitors.img,
        users.id AS id_pic,
        users.name as name_pic
        FROM visitors
        INNER JOIN users
        ON visitors.pic_id = users.id
        WHERE visitors.id='$id'
        ORDER BY visitors.created_at DESC, users.id DESC;");

        // dd($datas);

        return view('Report._viewReport', compact('datas'));
    }

    public function reportLocker()
    {
        $datas = DB::select("SELECT
                empl_id, empl_name, locker_name, created_at
            FROM
                locker_logs
            ORDER BY created_at DESC
        ");
        return view('Report.locker', compact('datas'));
    }
    public function reportAdministrator()
    {
        $activity = DB::select("SELECT 
        users.name as name,
        users.employee_id as employee_id,
        users.email as email,
        report_dashboards.action as action,
        report_dashboards.created_at as created_at,
        report_dashboards.id as id
        FROM
        users INNER JOIN report_dashboards
        ON users.id = report_dashboards.user_id ORDER BY id DESC");
        return view('Report.logAdministrator', compact('activity'));
    }

    public function reportParticipant()
    {
        $datas = DB::select("SELECT
                DATE_FORMAT(t_booking_rooms.meeting_date, '%b %d %Y') AS date,
                t_booking_rooms.room_name AS room,
                TIME(t_booking_rooms.h_start) AS start,
                TIME(t_booking_rooms.h_end) AS end,
                t_booking_participants.name AS name,
                t_booking_participants.email AS email,
                t_booking_participants.company AS company,
                t_booking_participants.phone AS phone,
                CASE
                    WHEN t_booking_participants.is_present = 0 THEN 'Absent'
                    WHEN t_booking_participants.is_present = 1 THEN 'Present'
                END AS status,
                t_booking_participants.present_at AS present_at
            FROM
                t_booking_participants
                    LEFT JOIN
                t_booking_rooms ON t_booking_rooms.id = t_booking_participants.book_id
            WHERE
                t_booking_rooms.meeting_date <= NOW()
                    AND h_start <= NOW()
            ORDER BY t_booking_rooms.meeting_date DESC
        ");
        return view('Report.participant', compact('datas'));
    }

    public function reportFnB()
    {
        $datas = DB::select("SELECT
                DATE_FORMAT(t_booking_rooms.meeting_date, '%b %d %Y') AS date,
                t_booking_rooms.room_name AS room,
                TIME(t_booking_rooms.h_start) AS start,
                TIME(t_booking_rooms.h_end) AS end,
                menus.name AS menu,
                t_booking_fnb.qty AS qty,
                CASE
                    WHEN t_booking_fnb.status = 0 THEN 'Reject'
                    WHEN t_booking_fnb.status = 1 THEN 'Reserved'
                    WHEN t_booking_fnb.status = 2 THEN 'Waiting'
                    WHEN t_booking_fnb.status = 3 THEN 'Done'
                END AS status
            FROM
                t_booking_fnb
                    LEFT JOIN
                menus ON menus.id = t_booking_fnb.menu_id
                    LEFT JOIN
                t_booking_rooms ON t_booking_rooms.id = t_booking_fnb.book_id
            WHERE
                t_booking_rooms.meeting_date IS NOT NULL
                    AND t_booking_rooms.meeting_date <= NOW()
                    AND h_start <= NOW()
            ORDER BY t_booking_rooms.meeting_date DESC
        ");
        return view('Report.fnb', compact('datas'));
    }

    public function reportFrontdesk()
    {
        $datas = DB::select("SELECT
                DATE_FORMAT(t_frontdesk.created_at, '%b %d %Y') AS date,
                TIME(t_frontdesk.created_at) AS time,
                t_booking_rooms.room_name AS room,
                TIME(t_booking_rooms.h_start) AS start,
                TIME(t_booking_rooms.h_end) AS end,
                t_frontdesk.msg AS msg,
                CASE
                    WHEN t_frontdesk.status = 1 THEN 'Pending'
                    WHEN t_frontdesk.status = 2 THEN 'Done'
                END AS status
            FROM
                t_frontdesk
                    LEFT JOIN
                t_booking_rooms ON t_booking_rooms.id = t_frontdesk.book_id
            ORDER BY t_booking_rooms.meeting_date DESC
        ");
        return view('Report.frontdesk', compact('datas'));
    }

    public function reportSecretary()
    {
        $datas = DB::select("SELECT
                DATE_FORMAT(t_secretaries.created_at, '%M %d %Y') AS date,
                TIME(t_secretaries.created_at) AS time,
                t_booking_rooms.room_name AS room,
                TIME(t_booking_rooms.h_start) AS start,
                TIME(t_booking_rooms.h_end) AS end,
                t_secretaries.msg AS msg,
                CASE
                    WHEN t_secretaries.status = 1 THEN 'Pending'
                    WHEN t_secretaries.status = 2 THEN 'Done'
                END AS status
            FROM
                t_secretaries
                    LEFT JOIN
                t_booking_rooms ON t_booking_rooms.id = t_secretaries.book_id
            ORDER BY t_booking_rooms.meeting_date DESC
        ");
        return view('Report.frontdesk', compact('datas'));
    }
}
