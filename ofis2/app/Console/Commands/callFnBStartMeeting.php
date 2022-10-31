<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use DateTime;
use DateTimeZone;
use Mail;
use Illuminate\Support\Facades\Log;

class callFnBStartMeeting extends Command
{
    protected $signature = 'process:callFnBStartMeeting';
    protected $description = 'call fnb to cleaning room before start meeting';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $findDatas = DB::select("SELECT
                *
            FROM
                t_booking_rooms
            WHERE
                status = 2
                AND DATE_FORMAT(NOW(),'%Y%m%d %H%i') = DATE_FORMAT(h_start + INTERVAL -5 MINUTE,'%Y%m%d %H%i');
        ");
        if ($findDatas != null) {
            $fnbs = DB::select("SELECT
                    name,
                    email
                FROM users
                WHERE user_type = 2
            ");

            foreach ($findDatas as $_data) {
                foreach ($fnbs as $_fnb) {
                    echo $_fnb->email;

                    $email_data['to'] = $_fnb->email;
                    $emailTo = new \stdClass();
                    $emailTo->name = $_fnb->name;

                    $room_name = $_data->room_name;

                    Mail::send('Mail._callFnbPrepareMeeting', compact('emailTo', 'room_name'), function ($message) use ($email_data) {
                        $message->to($email_data['to'])
                            ->subject('Room Preparation');
                    });
                }
            }
        }

        // echo 'works!';
        Log::info("CORN CALL FNB START MEETING IS WORKING");
        return 0;
    }
}
