<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use DateTime;
use DateTimeZone;
use Mail;
use Illuminate\Support\Facades\Log;

class CallFnB extends Command
{
    protected $signature = 'process:callFnB';
    protected $description = 'call fnb to cleaning room';

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
                status = 4
                AND DATE_FORMAT(NOW(),'%Y%m%d %H%i') = DATE_FORMAT(h_end + INTERVAL -8 MINUTE,'%Y%m%d %H%i');
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

                    Mail::send('Mail._callFnbDoneMeeting', compact('emailTo', 'room_name'), function ($message) use ($email_data) {
                        $message->to($email_data['to'])
                            ->subject('Room Preparation');
                    });
                }
            }
        }

        // echo 'works!';
        Log::info("CORN CALLFNB IS WORKING");
        return 0;
    }
}
