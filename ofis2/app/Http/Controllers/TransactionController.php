<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use Session;
use App\Models\User;
use App\Models\BookNow;
use App\Models\BookNowFnB;
use App\Models\BookNowParticipant;

use DB;

class TransactionController extends Controller
{
    public function index(){
        $transactions = DB::select("SELECT
                t_booking_rooms.id AS id,
                t_booking_rooms.meeting_date AS date,
                t_booking_rooms.desc AS `desc`,
                users.name AS pic_name,
                users.email AS pic_email,
                t_booking_rooms.h_start AS start,
                t_booking_rooms.h_end AS end,
                t_booking_rooms.room_name AS room,
                t_booking_rooms.desc AS description,
                t_booking_rooms.status  AS status
            FROM
                t_booking_rooms
            INNER JOIN
                users
            ON t_booking_rooms.user_id = users.id
            WHERE t_booking_rooms.status BETWEEN  2 AND 9 AND t_booking_rooms.status != 0
            ORDER BY t_booking_rooms.meeting_date DESC
        ");
        $approve = DB::select("SELECT
                t_booking_rooms.id AS id,
                t_booking_rooms.meeting_date AS date,
                t_booking_rooms.desc AS `desc`,
                users.name AS pic_name,
                users.email AS pic_email,
                t_booking_rooms.h_start AS start,
                t_booking_rooms.h_end AS end,
                t_booking_rooms.room_name AS room,
                t_booking_rooms.desc AS description,
                t_booking_rooms.status  AS status
            FROM
                t_booking_rooms
            INNER JOIN
                users
            ON t_booking_rooms.user_id = users.id
            WHERE t_booking_rooms.status = 1
            ORDER BY t_booking_rooms.meeting_date DESC
        ");
        $approveCount = DB::select("SELECT COUNT(id) AS `count` FROM t_booking_rooms WHERE status = 1");
        return view('Transaction.index', compact('transactions', 'approve', 'approveCount'));
    }

    public function view($id)
    {
        $books = BookNow::find($id);
        // $idTrx = $request->id;
        $pic = DB::select("SELECT
                t_booking_rooms.id AS id,
                users.name AS pic_name,
                users.email AS pic_email,
                users.phone AS pic_phone
            FROM
                t_booking_rooms
            INNER JOIN
                users
            ON t_booking_rooms.user_id = users.id
            WHERE t_booking_rooms.id =".$id);
        $participants = BookNowParticipant::All()->where('book_id', $id);
        $fnbs = DB::select("SELECT
            t_booking_fnb.id AS id,
            menus.name AS name,
            t_booking_fnb.qty AS qty,
            t_booking_fnb.notes AS notes
        FROM
            t_booking_fnb
        INNER JOIN
            menus
        ON t_booking_fnb.menu_id = menus.id
        WHERE t_booking_fnb.book_id =".$id);
        // dd($fnbs);
    return view('Transaction._view', compact('books', 'pic', 'participants', 'fnbs'));
    }
}
