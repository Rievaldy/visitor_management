<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Attendance;

class GetAttendance extends Command
{
    protected $signature = 'process:GetAttendance';
    protected $description = 'Get attendance data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $startTime = date('Y-m-d') . 'T00:00:00+07:00';
        $endTime = date('Y-m-d') . 'T23:59:59+07:00';
        // $startTime='2021-11-02T00:00:00+07:00';
        // $endTime='2021-11-02T23:59:59+07:00';

        // ? get attendance with dinamis data

        // $data = DB::select("SELECT * FROM fac_configurations WHERE status='1'");

        // $online2 = [];
        // foreach ($data as $querys2) {
        //     array_push($online2, $querys2->ip_fac);
        // }

        for ($i = 0; $i <= 100; $i++) {
            // $ipCamera = $online2;
            $ipCamera = array(
                '10.1.24.3:80',  // FAC 1
                '10.1.24.4:80',  // FAC 2
                '10.1.24.7:80',  // FAC 3
                '10.1.24.8:80',  // FAC 4
                '10.1.24.9:80',  // FAC 5
                '10.1.24.10:80', // FAC 6
            );

            $postFieldAcsEventCond = array(
                'AcsEventCond' => array(
                    'searchID' => "1",
                    'searchResultPosition' => $i,
                    'maxResults' => 1000,
                    'major' => 5,
                    'minor' => 75,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'thermometryUnit' => 'celcius',
                    'currTemperature' => 1

                ),
            );
            $psostFieldAcsEventCond = \json_encode($postFieldAcsEventCond);
            $res_datas = [];
            $facNo = 1;
            foreach ($ipCamera as $ip) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://' . $ip . '/ISAPI/AccessControl/AcsEvent?format=json',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $postFieldAcsEventCond,
                    CURLOPT_USERPWD => 'admin' . ":" . 'mrt12345',
                    CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
                    CURLOPT_HTTPHEADER => array(
                        'Connection: keep-alive',
                        'Accept: /',
                        'X-Requested-With: XMLHttpRequest',
                        'If-Modified-Since: 0',
                        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                        'Accept-Language: en-US,en;q=0.9,vi;q=0.8,en-GB;q=0.7'
                    ),
                ));

                $response = curl_exec($curl);
                $data = json_decode($response, true);
                foreach ($data['AcsEvent']['InfoList'] as $d) {
                    $checkEmployeeId = DB::select("SELECT
                            COUNT(id) AS id
                        FROM
                            users
                        WHERE
                            employee_id = '" . $d['employeeNoString'] . "'
                    ");
                    if ($checkEmployeeId[0]->id == 1) {
                        $checkDataAttendance = DB::select(
                            "SELECT
                                COUNT(id) AS id
                            FROM
                                attendance
                            WHERE
                                employee_id = '" . $d['employeeNoString'] . "'
                                    AND `date` = '" . date("Y-m-d 00:00:00", strtotime($d['time'])) . "'
                                    AND `time` = '" . date("Y-m-d H:i:s", strtotime($d['time'])) . "'
                                    AND attendance_type = 2
                                    AND status = 9"
                        );
                        $datas = DB::select("SELECT
                            id, name
                        FROM
                            users
                        WHERE
                            employee_id = '" . $d['employeeNoString'] . "'
                    ");
                        if ($checkDataAttendance[0]->id == 0) {
                            $attendance = new Attendance;
                            $attendance->user_id = $datas[0]->id;
                            $attendance->employee_id = $d['employeeNoString'];
                            $attendance->name = $datas[0]->name;
                            $attendance->date = date("Y-m-d 00:00:00", strtotime($d['time']));
                            $attendance->time = date("Y-m-d H:i:s", strtotime($d['time']));
                            $attendance->attendance_type = 2;
                            $attendance->fac_no = $facNo;
                            $attendance->status = 9;
                            $save = $attendance->save();
                        }
                    }
                }
                array_push($res_datas, $response);
                curl_close($curl);
                $facNo++;
            }
        }

        // $findAttendance = DB::select("SELECT
        //         employee_id AS id
        //     FROM
        //         attendance
        //     WHERE
        //         name IS NULL AND `user_id` IS NULL
        //     GROUP BY employee_id
        // ");

        // $findAttendance_array = [];
        // foreach ($findAttendance as $_findAttendance) {
        //     array_push($findAttendance_array,$_findAttendance->id);
        // };

        // foreach ($findAttendance_array as $z){
        //     $datas = DB::select("SELECT
        //             id, name
        //         FROM
        //             users
        //         WHERE
        //             employee_id = '".$z."'
        //     ");

        //     DB::update("UPDATE attendance SET `user_id` = '".$datas[0]->id."', `name` = '".$datas[0]->name."', updated_at = now() where employee_id = '".$z."'");
        //     // if($datas == null){
        //     //     DB::delete("DELETE FROM attendance WHERE employee_id = '".$z."'");
        //     // } else if ($datas != null) {
        //     //     DB::update("UPDATE attendance SET `user_id` = '".$datas[0]->id."', `name` = '".$datas[0]->name."', updated_at = now() where employee_id = '".$z."'");
        //     // }
        // }

        echo "works! \n";
        return 0;
    }
}
