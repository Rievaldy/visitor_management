<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Visitor;

class DeleteFacGuest extends Command
{
    protected $signature = 'process:DeleteFacGuest';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $checkDataVisitor = DB::select("SELECT
                unix_id AS uid
            FROM
                visitors
            WHERE
                unix_id LIKE 'GUEST%'
                    AND created_at = DATE(NOW())
                    AND is_fac_del = 0
        ");

        $checkDataVisitor_array = [];
        foreach ($checkDataVisitor as $_checkDataVisitor) {
            array_push($checkDataVisitor_array, $_checkDataVisitor->uid);
        };

        foreach ($checkDataVisitor_array as $z) {
            $ipCamera = array(
                '10.1.24.4:80', // FAC 2
                '10.1.24.3:80', // FAC 1
                '10.1.24.8:80', // FAC 4
                '10.1.24.9:80'  // FAC 5
            );
            $postFieldUserInfoDetail = array(
                'UserInfoDetail' => array(
                    'mode' => "byEmployeeNo",
                    'EmployeeNoList' => array(
                        array(
                            'employeeNo' => $z,
                        ),
                    ),
                ),
            );
            $postFieldUserInfoDetail = \json_encode($postFieldUserInfoDetail);
            $res_datas = [];
            foreach ($ipCamera as $ip) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://' . $ip . '/ISAPI/AccessControl/UserInfoDetail/Delete?format=json',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS => $postFieldUserInfoDetail,
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
                curl_close($curl);
                DB::update("UPDATE visitors SET `fac_del` = 1, updated_at = now() where unix_id = '" . $z . "'");
            }
        };

        echo "works! \n";
        return 0;
    }
}
