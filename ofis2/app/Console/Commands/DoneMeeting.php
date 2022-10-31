<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DoneMeeting extends Command
{
    protected $signature = 'process:doneMeeting';
    protected $description = 'Done meeting if time same as meeting end time';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = date('Y-m-d H:i:00');
        DB::update("UPDATE t_booking_rooms set status = 5, updated_at = now() WHERE status = 4 AND h_end = '".$now."'");

        $doneMeeting = DB::select("SELECT * FROM t_booking_rooms WHERE status = 5 AND h_end = '".$now."'");
        // dd($doneMeeting);
        if( $doneMeeting != null ) {
            $devices = DB::select("SELECT
                    room_facilities.id_facility AS id_facility,
                    facilities.name AS name,
                    room_facilities.device_id AS devices_id,
                    facilities.is_control AS is_control,
                    facilities.control_id AS control_id,
                    facility_cats.id AS cat_id,
                    locations.url_api AS url_api
                FROM room_facilities
                INNER JOIN
                    facilities
                ON room_facilities.id_facility = facilities.id
                INNER JOIN
                    facility_cats
                ON facilities.id_cat = facility_cats.id
                INNER JOIN
                rooms ON rooms.id = room_facilities.id_room
                INNER JOIN
                locations ON locations.id = rooms.id_loc
                WHERE room_facilities.id_room = '".$doneMeeting[0]->room_id."'
                AND facilities.is_control = 1
            ");

            $responses = array();

            foreach ($devices as $device) {

                $deviceId =$deviceId = $device->devices_id;
                $activityId=0;

                if($device->cat_id != 11){
                    $activityId = 0;
                }
                elseif($device->cat_id == 11) {
                    $activityId = 3;
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $device->url_api,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 2,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "deviceId": "'.$deviceId.'",
                        "activityId": "'.$activityId.'"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'accept: /',
                        'Content-Type: application/json'
                    ),
                    CURLOPT_SSL_VERIFYHOST=> 0,
                    CURLOPT_SSL_VERIFYPEER=> 0,
                ));

                $response = curl_exec($curl);
                $response = 'Success';
                if (curl_errno($curl)) {
                    $error_msg = curl_error($curl);
                    $response = $error_msg;
                }
                array_push($responses,array(
                    'device_id' => $device->devices_id,
                    'res' => $response
                ));
            }
            $res = array(
                'code' => 200,
                'msg' => array(
                    'title' => 'Welcome',
                    // 'body' => $checkParty[0]->name,
                ),
                'panda' => $responses
            );
            $res = array(
                    'code' => 200,
                    'msg' => array(
                        'title' => 'Welcome',
                        // 'body' => $checkParty[0]->name,
                    ),
                    'panda' => $responses
                );
        }

        echo 'works!';
        return 0;
    }
}
