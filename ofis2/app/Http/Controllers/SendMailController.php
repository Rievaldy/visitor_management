<?php

namespace App\Http\Controllers;

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

use DB;


class SendMailController extends Controller
{
    public function sendConfirm(Request $request, $id)
    {
        try {
            // $books = BookNow::find($id);
            // $pic = DB::select("SELECT
            //         users.name as pic_name,
            //         users.email as pic_email
            //     FROM
            //         t_booking_rooms
            //     INNER JOIN
            //         users ON t_booking_rooms.user_id = users.id
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $picData = DB::select("SELECT
            //         users.name as pic_name,
            //         users.email as pic_email
            //     FROM
            //         t_booking_rooms
            //     INNER JOIN
            //         users ON t_booking_rooms.user_id = users.id
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $pic_array = [];
            // foreach ($picData as $_picData) {
            //     array_push($pic_array,$_picData->pic_email);
            // };
            // $mail_data['to'] = $pic_array;
            // Mail::send('Mail._approvePic', compact('pic_array','pic'), function($message) use ($mail_data)
            // {
            //     $message->to($mail_data['to'])
            //         ->subject('Your booking has been approve');
            // });
            // $participants = DB::select("SELECT
            //         email,
            //         name,
            //         img
            //     FROM t_booking_participants
            //     WHERE t_booking_participants.book_id = $id
            // ");
            // $email_array = [];
            // foreach ($participants as $_parti) {
            //     array_push($email_array,$_parti->email);
            // }

            // $uid = DB::select("SELECT
            //         t_booking_rooms.uid_meeting
            //     FROM t_booking_rooms
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $descriptions = DB::select("SELECT
            //         t_booking_rooms.desc
            //     FROM t_booking_rooms
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $address = DB::select("SELECT
            //         t_booking_rooms.id AS booking_id,
            //         locations.address AS location_name
            //     FROM
            //         rooms
            //     INNER JOIN
            //         locations
            //     ON rooms.id_loc = locations.id
            //     INNER JOIN
            //         t_booking_rooms
            //     ON rooms.id = t_booking_rooms.room_id
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $meetingDate = DB::select("SELECT
            //         t_booking_rooms.meeting_date
            //     FROM t_booking_rooms
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $start = DB::select("SELECT
            //         t_booking_rooms.h_start
            //     FROM t_booking_rooms
            //     WHERE t_booking_rooms.id = $id
            // ");
            // $end = DB::select("SELECT
            //         t_booking_rooms.h_end
            //     FROM t_booking_rooms
            //     WHERE t_booking_rooms.id = $id
            // ");

            // $users = Auth::user();
            // $todaymeetingstamp = strtotime( $meetingDate[0]->meeting_date);
            // $todaystamp = gmdate('Ymd\THis\Z',);

            // $startmeetingstamp = strtotime( $start[0]->h_start);
            // $startTime = gmdate('Ymd\THis\Z', $startmeetingstamp);

            // $endmeetingstamp = strtotime( $end[0]->h_end);
            // $endTime =  gmdate('Ymd\THis\Z', $endmeetingstamp);
            // $organizer = "Smart Office MRT Jakarta";

            // $ics = array(
            //     "BEGIN:VCALENDAR",
            //     "VERSION:2.0",
            //     "PRODID:-//Google Inc//Google Calendar 70.9054//EN",
            //     "CALSCALE:GREGORIAN",
            //     "METHOD:REQUEST",
            //     "BEGIN:VEVENT",
            //     // "UID:".$uid[0]->uid_meeting.date('YmdHis'),
            //     "UID:".$uid[0]->uid_meeting,
            //     "SUMMARY:".$descriptions[0]->desc,
            //     "LOCATION:".$address[0]->location_name,
            //     "STATUS:CONFIRMED",
            //     "DTSTART:".$startTime,
            //     "DTEND:".$endTime,
            //     "DTSTAMP:2020608T000000Z",
            //     "ORGANIZER:".$organizer,
            //     // "ORGANIZER:".$pic[0]->pic_name,
            //     "BEGIN:VALARM",
            //     "ACTION:DISPLAY",
            //     "ATTENDEE;RSVP=TRUE;ROLE=REQ-PARTICIPANT:mailto:".$pic[0]->pic_email,
            //     "DESCRIPTION:Meeting will be start",
            //     "TRIGGER:-PT30M",
            //     "END:VALARM",
            //     "END:VEVENT",
            //     "END:VCALENDAR",
            // );
            // $ics = implode("\r\n", $ics);
            // foreach ( $participants as $emailTo ) {
            //     $email_data['event'] = $ics;
            //     $email_data['to'] = $emailTo->email;
            //     Mail::send('Mail._approve', compact('books','users','emailTo', 'pic', 'participants', 'address'), function($message) use ($email_data)
            //     {
            //         $message->to($email_data['to'])
            //         ->subject('Meeting Invitation')
            //         ->attachData($email_data['event'],'invite.ics', [
            //             'mime' => 'text/calendar;charset=UTF-8;method=REQUEST;name=invite.ics',
            //         ]);
            //     });
            // }

            // echo "Email berhasil dikirim.";

            $books = BookNow::find($id);
            $books->status = 9;
            $books->save();

            $updateStatus = 2;
            DB::table('t_booking_fnb')->where('book_id', $id)->where('status', '1')->update(['t_booking_fnb.status' => $updateStatus]);

            return redirect()->route('bookingList');
        } catch (\Exception $e) {
            echo "Email gagal dikirim karena $e.";
        }
    }

    public function sendRejectConfirm(Request $request, $id)
    {
        try {
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
            $picData = DB::select("SELECT
                    users.name as pic_name,
                    users.email as pic_email
                FROM
                    t_booking_rooms
                INNER JOIN
                    users ON t_booking_rooms.user_id = users.id
                WHERE t_booking_rooms.id = $id
            ");
            $pic_array = [];
            foreach ($picData as $_picData) {
                array_push($pic_array, $_picData->pic_email);
            };
            $mail_data['to'] = $pic_array;
            Mail::send('Mail._rejectApprovePic', compact('pic_array', 'pic'), function ($message) use ($mail_data) {
                $message->to($mail_data['to'])
                    ->subject('Your booking has been cancelled');
            });
            $participants = DB::select("SELECT
                    email,
                    name
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

            // $organizer = "Smart Office MRT Jakarta";
            // $created_at =  gmdate('Y-m-d', strtotime($meetingDate[0]->meeting_date));
            // $startTime =  gmdate('Y-m-d H:i', strtotime($start[0]->h_start));
            // $endTime =  gmdate('Y-m-d H:i', strtotime($end[0]->h_end));

            // $event = Calendar::create()->event(Event::create()
            //     ->uniqueIdentifier($uid['0']->uid_meeting)
            //     ->status(EventStatus::cancelled())
            //     // ->status(EventStatus::confirmed())
            //     ->name($descriptions['0']->desc)
            //     // ->description($descriptions['0']->desc)
            //     ->createdAt(new DateTime($created_at))
            //     ->startsAt(new DateTime($startTime))
            //     ->endsAt(new DateTime($endTime))
            //     ->address($address[0]->location_name)
            //     ->alertMinutesBefore(30, 'Meeting will be start')
            //     // ->organizer($pic[0]->pic_email, $pic[0]->pic_name)
            //     ->organizer($organizer)
            // );
            $users = Auth::user();
            $todaymeetingstamp = strtotime($meetingDate[0]->meeting_date);
            $startmeetingstamp = strtotime($start[0]->h_start);
            $endmeetingstamp = strtotime($end[0]->h_end);

            $todaystamp = gmdate('Ymd\THis\Z',);
            $startTime = gmdate('Ymd\THis\Z', $startmeetingstamp);
            $endTime =  gmdate('Ymd\THis\Z', $endmeetingstamp);

            $ics = array(
                "BEGIN:VCALENDAR",
                "VERSION:2.0",
                "PRODID:-//Google Inc//Google Calendar 70.9054//EN",
                "CALSCALE:GREGORIAN",
                "METHOD:REQUEST",
                "BEGIN:VEVENT",
                "UID:" . $uid[0]->uid_meeting,
                "SUMMARY:" . $descriptions[0]->desc,
                "LOCATION:" . $address[0]->location_name,
                "STATUS:CANCELLED",
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
                Mail::send('Mail._rejectApprove', compact('users', 'emailTo', 'pic', 'participants'), function ($message) use ($email_data) {
                    // $message->from('no-reply@ofis.com', 'Ofis Smart Meeting Room');
                    $message->to($email_data['to'])
                        ->subject('Meeting Invitation cancelled')
                        ->attachData($email_data['event'], 'cancel.ics', [
                            // 'mime' => 'text/calendar',
                            'mime' => 'text/calendar; charset="utf-8"; method=REQUEST;',
                        ]);
                });
            }

            echo "Email berhasil dikirim.";

            $books = BookNow::find($id);
            $books->status = 3;
            $books->save();

            $updateStatus = 3;
            DB::table('t_booking_fnb')->where('book_id', $id)->where('status', '1')->update(['t_booking_fnb.status' => $updateStatus]);

            return redirect()->route('bookingList');
        } catch (\Exception $e) {
            echo "Email gagal dikirim karena $e.";
        }
    }

    public function sendReject(Request $request, $id)
    {
        try {
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
            $email_array = [];
            foreach ($pic as $_pic) {
                array_push($email_array, $_pic->pic_email);
            }
            $email_data['to'] = $email_array;
            Mail::send('Mail._reject', compact('email_array', 'pic'), function ($message) use ($email_data) {
                $message->to($email_data['to'])
                    ->subject('Meeting Invitation Rejected');
            });

            echo "Email berhasil dikirim.";

            $books = BookNow::find($id);
            $books->status = 3;
            $books->save();

            $updateStatus = 3;
            DB::table('t_booking_fnb')->where('book_id', $id)->where('status', '1')->update(['t_booking_fnb.status' => $updateStatus]);

            return redirect()->route('bookingList');
        } catch (\Exception $e) {
            echo "Email gagal dikirim karena $e.";
        }
    }
}
