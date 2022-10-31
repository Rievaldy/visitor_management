<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;

class ActiveMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:activeMeeting';
    protected $description = 'Active meeting if time same as meeting start time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $now = date('Y-m-d H:i:00');
        DB::update("UPDATE t_booking_rooms set status = 4, updated_at = now() where status = 2 and h_start = '" . $now . "'");
        // echo 'works!';
        Log::info("CORN ACTIVE MEETING IS WORKING");


        return 0;
    }
}

// php ~/Sites/smartMr/artisan process:activeMeeting

// * * * * * php ~/Sites/smartMr/artisan process:activeMeeting
