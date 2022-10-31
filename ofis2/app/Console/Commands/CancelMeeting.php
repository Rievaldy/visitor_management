<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\EventStatus;
use DB;
use DateTime;
use DateTimeZone;
use Mail;
use Illuminate\Support\Facades\Log;


class CancelMeeting extends Command
{
    protected $signature = 'process:cancelMeeting';
    protected $description = 'Cancel meeting afte if participant 0';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $books = DB::select("SELECT
                *
            FROM
                t_booking_rooms
                    LEFT JOIN
                (SELECT
                    book_id,
                        SUM(is_present) AS total_present,
                        CONCAT('[',
                            GROUP_CONCAT(JSON_OBJECT('name', name, 'email', email)),
                        ']') AS parti_list
                FROM
                    t_booking_participants
                GROUP BY book_id) parti ON parti.book_id = t_booking_rooms.id
                    LEFT JOIN
                (SELECT
                    rooms.id AS room_id, locations.address AS address
                FROM
                    rooms
                LEFT JOIN locations ON rooms.id_loc = locations.id) locations ON locations.room_id = t_booking_rooms.room_id
                    LEFT JOIN
                (SELECT
                    users.email AS pic_email, users.name AS pic_name, users.id AS pic_id
                FROM
                    users) pic ON pic.pic_id = t_booking_rooms.user_id
            WHERE
                status = 4 AND total_present = 0
                    -- AND h_start <= (NOW() - INTERVAL 30 MINUTE)
                    AND h_start <= (NOW() - INTERVAL 30 MINUTE)
        ");

        if ($books != null) {
            // DB::update("update t_booking_rooms set status = 3, updated_at = now() where t_booking_rooms.id = '".$books->id."'");
            DB::update("UPDATE t_booking_rooms,
                (SELECT
                    book_id, SUM(is_present) AS total_present
                FROM
                    t_booking_participants
                GROUP BY book_id) parti
            SET
                status = 0
            WHERE
                t_booking_rooms.id = parti.book_id
                    AND status = 4
                    AND total_present = 0
                    AND h_start <= (NOW() - INTERVAL 30 MINUTE)");
        }

        foreach ($books as $_book) {
            // dd($_book->id);
            // $created_at =  gmdate('Y-m-d', strtotime($_book->meeting_date));
            // $startTime =  gmdate('Y-m-d H:i', strtotime($_book->h_start));
            // $endTime =  gmdate('Y-m-d H:i', strtotime($_book->h_end));
            // $organizer = "Smart Office MRT Jakarta";

            // $event = Calendar::create()->event(Event::create()
            //     ->uniqueIdentifier($_book->uid_meeting)
            //     ->status(EventStatus::cancelled())
            //     ->name($_book->desc)
            //     ->createdAt(new DateTime($created_at))
            //     ->startsAt(new DateTime($startTime))
            //     ->endsAt(new DateTime($endTime))
            //     ->address($_book->address)
            //     // ->organizer($_book->pic_email, $_book->pic_name)
            //     ->organizer($organizer)
            // );
            $todaymeetingstamp = strtotime($_book->meeting_date);
            $todaystamp = gmdate('Ymd\THis\Z', $todaymeetingstamp);

            $startmeetingstamp = strtotime($_book->h_start);
            $startTime = gmdate('Ymd\THis\Z', $startmeetingstamp);

            $endmeetingstamp = strtotime($_book->h_end);
            $endTime =  gmdate('Ymd\THis\Z', $endmeetingstamp);
            $ics = array(
                "BEGIN:VCALENDAR",
                "VERSION:2.0",
                "PRODID:-//Google Inc//Google Calendar 70.9054//EN",
                "CALSCALE:GREGORIAN",
                "METHOD:REQUEST",
                "BEGIN:VEVENT",
                "UID:" . $_book->uid_meeting,
                "SUMMARY:" . $_book->desc,
                "LOCATION:" . $_book->address,
                "STATUS:CANCELLED",
                "DTSTART:" . $startTime,
                "DTEND:" . $endTime,
                "DTSTAMP:" . $startTime,
                "ATTENDEE;RSVP=TRUE;ROLE=REQ-PARTICIPANT:mailto:" . $_book->pic_email,
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

            $parti_list = json_decode($_book->parti_list);
            foreach ($parti_list as $partilist) {
                $email_data['event'] = $ics;
                $email_data['to'] = $partilist->email;

                $emailTo = new \stdClass();
                $emailTo->name = $partilist->name;

                $pic = [];
                $x = new \stdClass();
                $x->pic_name = $_book->pic_name;
                array_push($pic, $x);

                Mail::send('Mail._autoCancel', compact('emailTo', 'pic'), function ($message) use ($email_data) {
                    $message->to($email_data['to'])
                        ->subject('30 Minutes Empty Meeting')
                        ->attachData($email_data['event'], 'cancel.ics', [
                            'mime' => 'text/calendar; charset="utf-8"; method=REQUEST;',
                        ]);
                });
            }
        }
        // echo 'works!';
        Log::info("CORN CALL FNB START MEETING IS WORKING");
        return 0;
    }
}
