<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Secretary extends Model
{
    use HasFactory, Notifiable;

    protected $table = "t_secretaries";
	protected $primaryKey = "id";

    public static function getReport(){
        $datas = DB::select("SELECT
                -- ROW_NUMBER() OVER() AS No,
                DATE_FORMAT(t_secretaries.created_at, '%M %d %Y') AS date,
                TIME(t_secretaries.created_at) AS time,
                t_booking_rooms.room_name AS room,
                TIME(t_booking_rooms.h_end) AS start,
                TIME(t_booking_rooms.h_start) AS end,
                t_secretaries.msg,
                CASE
                    WHEN t_secretaries.status = 1 THEN 'Pending'
                    WHEN t_secretaries.status = 2 THEN 'Done'
                END AS status
            FROM
                t_secretaries
                    LEFT JOIN
                t_booking_rooms ON t_booking_rooms.id = t_secretaries.book_id
        ");
        return $datas;
    }
}
