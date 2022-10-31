<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\EventStatus;
use App\Models\User;
use App\Models\BookNow;
use App\Models\BookNowFnB;
use App\Models\BookNowParticipant;
use DateTime;
use DateTimeZone;
use Mail;
use Illuminate\Support\Facades\Log;

use DB;

class ApproveMeeting extends Command
{
    protected $signature = 'process:approveMeeting';
    protected $description = 'Approve meeting automatically if status book = 9';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $findBoking = DB::select("SELECT * FROM t_booking_rooms WHERE status = 9");
        $findBoking_array = [];
        foreach ($findBoking as $_findBoking) {
            array_push($findBoking_array, $_findBoking->id);
        };

        foreach ($findBoking_array as $id) {
            $books = BookNow::find($id);

            $pic = DB::select("SELECT
                    users.name as pic_name,
                    users.email as pic_email
                FROM
                    t_booking_rooms
                INNER JOIN
                    users ON t_booking_rooms.user_id = users.id
                WHERE t_booking_rooms.id = $id
            ");
            $pic_array = [];
            foreach ($pic as $_picData) {
                array_push($pic_array, $_picData->pic_email);
            };
            $participants = DB::select("SELECT
                    email,
                    name,
                    img
                FROM t_booking_participants
                WHERE t_booking_participants.book_id = $id
            ");
            $email_array = [];
            foreach ($participants as $_parti) {
                array_push($email_array, $_parti->email);
            }

            $uid = DB::select("SELECT
                    t_booking_rooms.uid_meeting
                FROM t_booking_rooms
                WHERE t_booking_rooms.id = $id
            ");
            $descriptions = DB::select("SELECT
                    t_booking_rooms.desc
                FROM t_booking_rooms
                WHERE t_booking_rooms.id = $id
            ");
            $address = DB::select("SELECT
                    t_booking_rooms.id AS booking_id,
                    locations.address AS location_name
                FROM
                    rooms
                INNER JOIN
                    locations
                ON rooms.id_loc = locations.id
                INNER JOIN
                    t_booking_rooms
                ON rooms.id = t_booking_rooms.room_id
                WHERE t_booking_rooms.id = $id
            ");
            $meetingDate = DB::select("SELECT
                    t_booking_rooms.meeting_date
                FROM t_booking_rooms
                WHERE t_booking_rooms.id = $id
            ");
            $start = DB::select("SELECT
                    t_booking_rooms.h_start
                FROM t_booking_rooms
                WHERE t_booking_rooms.id = $id
            ");
            $end = DB::select("SELECT
                    t_booking_rooms.h_end
                FROM t_booking_rooms
                WHERE t_booking_rooms.id = $id
            ");

            $mail_data['to'] = $pic_array;
            Mail::send('Mail._approvePic', compact('pic_array', 'pic'), function ($message) use ($mail_data) {
                $message->to($mail_data['to'])
                    ->subject('Your booking has been approve');
            });

            $users = Auth::user();
            $todaymeetingstamp = strtotime($meetingDate[0]->meeting_date);
            $todaystamp = gmdate('Ymd\THis\Z', $todaymeetingstamp);

            $startmeetingstamp = strtotime($start[0]->h_start);
            $startTime = gmdate('Ymd\THis\Z', $startmeetingstamp);

            $endmeetingstamp = strtotime($end[0]->h_end);
            $endTime =  gmdate('Ymd\THis\Z', $endmeetingstamp);
            //$organizer = "Smart Office MRT Jakarta";

            $ics = array(
                "BEGIN:VCALENDAR",
                "VERSION:2.0",
                "PRODID:-//Google Inc//Google Calendar 70.9054//EN",
                "CALSCALE:GREGORIAN",
                "METHOD:REQUEST",
                "BEGIN:VEVENT",
                // "UID:".$uid[0]->uid_meeting.date('YmdHis'),
                "UID:" . $uid[0]->uid_meeting,
                "SUMMARY:" . $descriptions[0]->desc,
                "LOCATION:" . $address[0]->location_name,
                "STATUS:CONFIRMED",
                "DTSTART:" . $startTime,
                "DTEND:" . $endTime,
                "DTSTAMP:" . $startTime,
                "ATTENDEE;RSVP=TRUE;ROLE=REQ-PARTICIPANT:mailto:" . $pic[0]->pic_email,
                // "ORGANIZER;CN=Smart Office MRT Jakarta:mailto:smartoffice@jakartamrt.co.id",
                "ORGANIZER;CN=Smart Office MRT Jakarta:mailto:smartofficemrt@gmail.com",
                "BEGIN:VALARM",
                "ACTION:DISPLAY",
                "DESCRIPTION:Meeting will be start",
                "TRIGGER:-PT30M",
                "END:VALARM",
                "END:VEVENT",
                "END:VCALENDAR",
            );
            $ics = implode("\r\n", $ics);

            foreach ($participants as $emailTo) {
                $email_data['event'] = $ics;
                $email_data['to'] = $emailTo->email;
                Mail::send('Mail._approve', compact('books', 'users', 'emailTo', 'pic', 'participants', 'address'), function ($message) use ($email_data) {
                    $message->to($email_data['to'])
                        ->subject('Meeting Invitation')
                        ->attachData($email_data['event'], 'invite.ics', [
                            'mime' => 'text/calendar; charset="utf-8"; method=REQUEST;',
                        ]);
                });
            }

            $books = BookNow::find($id);
            $books->status = 2;
            $books->save();
            $updateStatus = 2;
            DB::table('t_booking_fnb')->where('book_id', $id)->where('status', '1')->update(['t_booking_fnb.status' => $updateStatus]);
        }

        Log::info("CORN APPROVE MEETING IS WORKING");
        // echo 'works!';
        return 0;
    }
}
