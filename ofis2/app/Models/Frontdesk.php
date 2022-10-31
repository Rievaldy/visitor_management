<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Frontdesk extends Model
{
    use HasFactory, Notifiable;

    protected $table = "t_frontdesk";
	protected $primaryKey = "id";

    public static function getReport(){
        $datas = DB::select("SELECT
                -- ROW_NUMBER() OVER() AS No,
                DATE_FORMAT(t_frontdesk.created_at, '%M %d %Y') AS date,
                TIME(t_frontdesk.created_at) AS time,
                t_booking_rooms.room_name AS room,
                TIME(t_booking_rooms.h_end) AS start,
                TIME(t_booking_rooms.h_start) AS end,
                t_frontdesk.msg,
                CASE
                    WHEN t_frontdesk.status = 1 THEN 'Pending'
                    WHEN t_frontdesk.status = 2 THEN 'Done'
                END AS status
            FROM
                t_frontdesk
                    LEFT JOIN
                t_booking_rooms ON t_booking_rooms.id = t_frontdesk.book_id
        ");
        return $datas;
    }
}
