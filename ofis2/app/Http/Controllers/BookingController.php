<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Hash;
use Session;
use App\Models\User;
use App\Models\Room;
use App\Models\BookNow;
use App\Models\BookNowParticipant;
use App\Models\BookMenu;
use App\Models\BookNowFnB;
use DB;
use DateTime;
use DateTimeZone;
use Mail;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function myBooking()
    {
        $users = Auth::user();
        // $books = BookNow::All()->where('user_id', $users->id);
        $activebooks = DB::select("SELECT
                *
            FROM
                t_booking_rooms
            WHERE
                user_id = $users->id AND status != 0 AND status < 3 OR status = 4 OR status = 9
            -- ORDER BY t_booking_rooms.created_at DESC
            ORDER BY t_booking_rooms.status DESC, t_booking_rooms.status = 1, t_booking_rooms.created_at DESC
        ");
        // dd($activebooks);
        $archivebooks = DB::select("SELECT
                *
            FROM
                t_booking_rooms
            WHERE
                user_id = $users->id AND status > 2  OR status = 9 OR status = 0
            ORDER BY t_booking_rooms.created_at DESC
            -- ORDER BY t_booking_rooms.status = 5, t_booking_rooms.created_at DESC
        ");
        // dd($activebooks);
        return view('Booking.myBooking', compact('users', 'activebooks', 'archivebooks'));
    }

    public function index()
    {
        $rooms = DB::select("SELECT
                *
            FROM
                rooms");

        return view('Booking.bookNow', compact('rooms'));
    }

    public function listResourceApi(Request $request)
    {
        $event = DB::select("SELECT
                rooms.id AS id,
                CONCAT(rooms.name, ' ', '(Capacity ',rooms.capacity,')') AS title,
                rooms.name AS room_name,
                rooms.capacity AS capacity,
                room_days.room_id AS room_id,
                rooms.name AS room_name,
                room_days.day_name AS days,
                room_images.img,
                CONCAT('[',
                    GROUP_CONCAT(JSON_OBJECT('name',
                                facilities.name,
                                'deviceId',
                                room_facilities.device_id)),
                    ']') AS facility
            FROM room_days
            INNER JOIN
                rooms ON room_days.room_id = rooms.id
            INNER JOIN
                room_images ON rooms.id = room_images.id_room
            INNER JOIN
                room_facilities ON rooms.id = room_facilities.id_room
            INNER JOIN
                facilities ON room_facilities.id_facility = facilities.id
            WHERE room_days.day_name = '" . $_GET['date'] . "'
            AND rooms.status = 1
            GROUP BY room_id
            ORDER BY rooms.name
        ");
        return response()->json($event);
    }

    public function listAvailRoomApi(Request $request)
    {
        $date = $request->date = date('l', strtotime($request->date));
        $event = DB::select("SELECT
                room_id as id,
                name as text
            FROM
                room_days
                    INNER JOIN
                rooms ON room_days.room_id = rooms.id
            WHERE
                rooms.status = 1 AND day_name = '" . $date . "'
            ORDER BY room_id
        ");
        return response()->json($event);
        dd($event);
    }

    public function listEventApi(Request $request)
    {
        $event = DB::select("SELECT
            id,
            room_id AS resourceId,
            h_start AS start,
            h_end AS end,
            `desc` AS title
        FROM t_booking_rooms
        WHERE date(h_start) = '" . $_GET['date'] . "'
        AND status = 2 OR status BETWEEN 4 AND 10
        ");
        return response()->json($event);
    }

    public function autocomplete(Request $request)
    {

        $search = $request->cari;
        $userData = DB::select("SELECT
                email,
                name,
                company,
                phone
            FROM users
            WHERE email like '%" . $search . "%'
            AND user_type = 3 AND 99
        ");
        // dd($userData);

        $emailUserData = [];
        foreach ($userData as $_userData) {
            array_push($emailUserData, $_userData->email);
        }
        $emailUserData = implode("','", $emailUserData);
        $participantsData = DB::select("SELECT
            email,
            name,
            phone,
            company
        FROM
            t_booking_participants
        WHERE
            id IN (SELECT
                    MAX(id)
                FROM
                    t_booking_participants
                WHERE
                email like '%" . $search . "%'
                AND email not in ('" . $emailUserData . "')
                GROUP BY email
            )
        ");

        $response = [];
        foreach ($userData as $_party) {
            $response[] = array(
                "label" => $_party->email,
                "email" => $_party->email,
                "name" => $_party->name,
                "company" => $_party->company,
                "phone" => $_party->phone
            );
        };
        foreach ($participantsData as $_party) {
            $response[] = array(
                "label" => $_party->email,
                "email" => $_party->email,
                "name" => $_party->name,
                "company" => $_party->company,
                "phone" => $_party->phone
            );
        };
        return response()->json($response);
    }

    public function add(Request $request)
    {

        // asd2
        $user = User::find(Auth::user()->id);

        $room_id = $request->room_id;
        $room_name = $request->room_name;
        $room_capacity = $request->room_capacity;
        $meeting_date = $request->meeting_date;
        $meeting_date_dom = $request->meeting_date_dom;
        $h_start = $request->h_start;
        $h_end = $request->h_end;

        $h_start_dom = $request->h_start_dom;
        $h_end_dom = $request->h_end_dom;

        $startNow = strtotime($h_start_dom);
        $endNow = strtotime($h_end_dom);

        // $startTimeNow = date("H:i:s", strtotime('-1 minutes', $startNow));
        // $startTimeNowPlus = date("H:i:s", strtotime('+1 minutes', $startNow));
        // $endTimeNow = date("H:i:s", strtotime('-1 minutes', $endNow));
        // $endTimeNowPlus = date("H:i:s", strtotime('+1 minutes', $endNow));

        // $startTime = $dateStartNow . ' ' . $startTimeNow;
        // $startTimePlus = $dateStartNow . ' ' . $startTimeNowPlus;
        // $endTime = $dateStartNow . ' ' . $endTimeNow;
        // $endTimePlus = $dateStartNow . ' ' . $endTimeNowPlus;

        $dateStartNow = date("Y-m-d", strtotime($meeting_date));
        $startTime = date("H:i:s", strtotime($h_start_dom));
        $endTime = date("H:i:s", strtotime($h_end_dom));
        $checkSchedule = DB::select("SELECT
                COUNT(id) AS id
            FROM
                t_booking_rooms
            WHERE
                room_id = '" . $room_id . "'
                    AND DATE(meeting_date) = '" . $dateStartNow . "'
                    AND '" . $startTime . "' < TIME(h_end)
                    AND '" . $endTime . "' > TIME(h_start)
                    AND status IN (2 , 4, 9)
        ");

        $room_image = DB::select("SELECT
                rooms.id AS room_id,
                room_images.img AS img
            FROM
                rooms
                    INNER JOIN
                room_images ON rooms.id = room_images.id_room
            WHERE rooms.id = $room_id
        ");

        $ardi = Auth::user()->id;
        $secretary = DB::select("SELECT user_type FROM `users` WHERE id='$ardi';");
        $secretarys = $secretary[0]->user_type;

        $needApprove = DB::select(
            "SELECT
                is_need_approve
            FROM rooms
            WHERE id =" . $room_id
        );

        $facilities = DB::select("SELECT
                rooms.id AS room_id,
                room_facilities.id AS facilityId,
                facilities.name AS name
            FROM
                rooms
                    INNER JOIN
                room_facilities ON rooms.id = room_facilities.id_room
                    INNER JOIN
                facilities ON facilities.id = room_facilities.id_facility
            WHERE rooms.id = $room_id
        ");
        // dd($room_image[0]->img);
        // dd($facilities);

        $menus = DB::select("SELECT
                menus.id AS id,
                menus.name AS name,
                menu_cats.name AS category,
                menus.status AS status,
                menus.created_at AS created,
                menus.updated_at AS updated
            FROM
                menus
                    INNER JOIN
                menu_cats ON menus.id_cat = menu_cats.id
            WHERE menus.status = 1
            ORDER BY menus.created_at ASC
        ");

        // $checkSchedule = DB::select("SELECT
        //     COUNT(id) AS id
        //     FROM t_booking_rooms
        //     WHERE
        //         room_id = '".$room_id."'
        //         AND
        //         ((status = 2) OR (status = 4) OR (status = 9))
        //         AND
        //         (
        //             (h_start BETWEEN '".$startTime."' AND '".$endTime."')
        //         OR (h_end BETWEEN '".$startTimePlus."' AND '".$endTime."')
        //         OR (h_start BETWEEN '".$startTimePlus."' AND '".$endTime."'))
        // ");

        // $checkSchedule = DB::select("SELECT
        //         COUNT(id) AS id
        //     FROM
        //         t_booking_rooms
        //     WHERE
        //         room_id = '".$room_id."'
        //             AND DATE(meeting_date) = '".$dateStartNow."'
        //             AND '".$startTime."' < TIME(h_end)
        //             AND '".$endTime."' > TIME(h_start)
        //             AND status IN (2 , 4, 9)
        // ");
        if ($checkSchedule[0]->id == 0) {
            return view('Booking._book', compact('user', 'room_id', 'room_name', 'room_capacity', 'meeting_date', 'h_start', 'h_end', 'meeting_date_dom', 'h_start_dom', 'h_end_dom', 'room_image', 'facilities', 'menus', 'needApprove', 'secretarys'));
        } else {
            Session::flash('error', 'You can not book at the hour you choose because there is already a booking between the hours you choose.');
            return redirect()->route('bookNow');
        }
    }

    public function addNow(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $room_id = $request->room_id;
        $name = DB::select("SELECT name FROM rooms WHERE id = '" . $room_id . "'");
        $room_name = $name[0]->name;
        $capacity = DB::select("SELECT capacity FROM rooms WHERE id = '" . $room_id . "'");
        $room_capacity = $capacity[0]->capacity;

        $meeting_date = $request->meeting_date = date('Y-m-d', strtotime($request->meeting_date));
        $meeting_date_dom = $request->meeting_date = date('M d, Y', strtotime($request->meeting_date));
        $h_start = $request->h_start_dom;
        $h_end = $request->h_end_dom;
        $h_start_dom = $request->h_start_dom;
        $h_end_dom = $request->h_end_dom;

        $startNow = strtotime($h_start_dom);
        $endNow = strtotime($h_end_dom);

        $dateStartNow = date("Y-m-d", strtotime($meeting_date));
        $startTime = date("H:i:s", strtotime($h_start));
        $endTime = date("H:i:s", strtotime($h_end));
        $checkSchedule = DB::select("SELECT
                COUNT(id) AS id
            FROM
                t_booking_rooms
            WHERE
                room_id = '" . $room_id . "'
                    AND DATE(meeting_date) = '" . $dateStartNow . "'
                    AND '" . $startTime . "' < TIME(h_end)
                    AND '" . $endTime . "' > TIME(h_start)
                    AND status IN (2 , 4, 9)
        ");

        $room_image = DB::select("SELECT
                rooms.id AS room_id,
                room_images.img AS img
            FROM
                rooms
                    INNER JOIN
                room_images ON rooms.id = room_images.id_room
            WHERE rooms.id = $room_id
        ");

        $ardi = Auth::user()->id;
        $secretary = DB::select("SELECT user_type FROM `users` WHERE id='$ardi';");
        $secretarys = $secretary[0]->user_type;

        $needApprove = DB::select(
            "SELECT
                is_need_approve
            FROM rooms
            WHERE id =" . $room_id
        );

        $facilities = DB::select("SELECT
                rooms.id AS room_id,
                room_facilities.id AS facilityId,
                facilities.name AS name
            FROM
                rooms
                    INNER JOIN
                room_facilities ON rooms.id = room_facilities.id_room
                    INNER JOIN
                facilities ON facilities.id = room_facilities.id_facility
            WHERE rooms.id = $room_id
        ");
        // dd($room_image[0]->img);
        // dd($facilities);

        $menus = DB::select("SELECT
                menus.id AS id,
                menus.name AS name,
                menu_cats.name AS category,
                menus.status AS status,
                menus.created_at AS created,
                menus.updated_at AS updated
            FROM
                menus
                    INNER JOIN
                menu_cats ON menus.id_cat = menu_cats.id
            WHERE menus.status = 1
            ORDER BY menus.created_at ASC
        ");

        // $checkSchedule = DB::select("SELECT
        //     COUNT(id) AS id
        //     FROM t_booking_rooms
        //     WHERE
        //         room_id = '".$room_id."'
        //         AND
        //         ((status = 2) OR (status = 4) OR (status = 9))
        //         AND
        //         (
        //             (h_start BETWEEN '".$startTime."' AND '".$endTime."')
        //         OR (h_end BETWEEN '".$startTimePlus."' AND '".$endTime."')
        //         OR (h_start BETWEEN '".$startTimePlus."' AND '".$endTime."'))
        // ");
        $checkSchedule = DB::select("SELECT
                COUNT(id) AS id
            FROM
                t_booking_rooms
            WHERE
                room_id = '" . $room_id . "'
                    AND DATE(meeting_date) = '" . $dateStartNow . "'
                    AND '" . $startTime . "' < TIME(h_end)
                    AND '" . $endTime . "' > TIME(h_start)
                    AND status IN (2 , 4, 9)
        ");
        if ($checkSchedule[0]->id == 0) {
            return view('Booking._book', compact('user', 'room_id', 'room_name', 'room_capacity', 'meeting_date', 'h_start', 'h_end', 'meeting_date_dom', 'h_start_dom', 'h_end_dom', 'room_image', 'facilities', 'menus', 'needApprove', 'secretarys'));
        } else {
            Session::flash('error', 'You can not book at the hour you choose because there is already a booking between the hours you choose.');
            return redirect()->route('bookNow');
        }
    }

    public function store(Request $request)
    {

        //new
        $room_id = $request->room_id;

        $meeting_date = $request->meeting_date = date('Y-m-d', strtotime($request->meeting_date));

        $h_start = $request->h_start_dom;
        $h_end = $request->h_end_dom;
        $h_start_dom = $request->h_start_dom;
        $h_end_dom = $request->h_end_dom;

        $startNow = strtotime($h_start_dom);
        $endNow = strtotime($h_end_dom);

        $dateStartNow = date("Y-m-d", strtotime($meeting_date));
        $startTime = date("H:i:s", strtotime($h_start));
        $endTime = date("H:i:s", strtotime($h_end));

        $checkSchedule = DB::select("SELECT
                COUNT(id) AS id
            FROM
                t_booking_rooms
            WHERE
                room_id = '" . $room_id . "'
                    AND DATE(meeting_date) = '" . $dateStartNow . "'
                    AND '" . $startTime . "' < TIME(h_end)
                    AND '" . $endTime . "' > TIME(h_start)
                    AND status IN (2 , 4, 9)
        ");

        // //old

        // $room_id = $request->room_id;
        // $h_start_dom = $request->h_start_dom;
        // $h_end_dom = $request->h_end_dom;
        // $meeting_date = $request->meeting_date;

        // // mix date and time
        // $start = $meeting_date . ' ' . $h_start_dom;
        // $end = $meeting_date . ' ' . $h_end_dom;

        // $checkSchedule = DB::select("SELECT
        //         COUNT(id) AS id
        //     FROM
        //         t_booking_rooms
        //     WHERE
        //         room_id = '" . $room_id . "'
        //             AND DATE(meeting_date) = '" . $dateStartNow . "'
        //             AND '" . $startTime . "' < TIME(h_end)
        //             AND '" . $endTime . "' > TIME(h_start)
        //             AND status IN (2 , 4, 9)
        // ");
        $meeting_date = $request->meeting_date;
        // dd($meeting_date);
        $start =  $meeting_date . ' ' . $request->h_start_dom . ':00';
        $now = date('Y-m-d H:i:s');
        // dd($start);

        // $start = '2022-06-17 08:00:00';
        // $now = '2022-06-15 12:00:00';


        $selisih = DB::select("SELECT timediff('$start', '$now') as selisih;");

        // dd($now, $start, $selisih[0]);

        if ($selisih[0]->selisih > '00:05:00') {

            if ($checkSchedule[0]->id == 0) {

                // Start validate
                $user = User::find(Auth::user()->id);
                $room_id = $request->room_id;
                $room_name = $request->room_name;
                $room_capacity = $request->room_capacity;
                $meeting_date = $request->meeting_date;
                $h_start_dom = $request->h_start_dom;
                $h_end_dom = $request->h_end_dom;

                $startTime = $meeting_date . ' ' . $h_start_dom;
                $endTime = $meeting_date . ' ' . $h_end_dom;
                // Available alpha caracters
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                // generate a uid_meet based on 2 * 7 digits + a random character
                $uid_meet = mt_rand(1000000, 9999999)
                    . mt_rand(1000000, 9999999)
                    . $characters[rand(0, strlen($characters) - 1)];
                // shuffle the result
                $string = str_shuffle($uid_meet);

                DB::beginTransaction();
                $book = new BookNow;
                // $book->uid_meeting = ($request->uid_meeting);
                $book->uid_meeting = ($uid_meet);
                $book->user_id = ($user->id);
                $book->room_id = ($room_id);
                $book->room_name = ucwords(strtolower($room_name));
                $book->room_capacity = ($room_capacity);
                $book->meeting_date = ($meeting_date);
                $book->h_start = ($startTime);
                $book->h_end = ($endTime);
                $book->desc = ($request->desc);
                $book->status = ($request->book_status);
                $save = $book->save();
                // dd($book);

                $participants = [];
                foreach ($request->name as $key => $val) {
                    //error imagic
                    $code = QrCode::format('png')->size(512)->margin(2)->generate($request->email[$key]);

                    $participant = new BookNowParticipant;
                    $participant->book_id = $book->id;
                    $participant->name = $request->name[$key];
                    $participant->email = $request->email[$key];
                    $participant->company = $request->company[$key];
                    $participant->phone = $request->phone[$key];
                    $participant->status = $request->status[$key];
                    $participant->img = 'data:image/png;base64,' . base64_encode($code);
                    array_push($participants, $participant);
                    $save = $participant->save();
                }
                if ($request->menu_id != null) {
                    $menus = [];
                    foreach ($request->menu_id as $key => $val) {
                        if ($request->qty[$key] != null) {
                            $menu = new BookNowFnB;
                            $menu->book_id = $book->id;
                            $menu->menu_id = $request->menu_id[$key];
                            $menu->qty = $request->qty[$key];
                            $menu->notes = ucwords(strtolower($request->notes[$key]));
                            $menu->status = $request->status[$key];
                            array_push($menus, $menu);
                            $save = $menu->save();
                        }
                    }
                }
                // dd($save = $participant->save());

                // dd($request->name, $request->email, $request->company, $request->status, $request->book_status);
                $ardi = Auth::user()->id;
                $secretary = DB::select("SELECT user_type FROM `users` WHERE id='$ardi';");
                $secretarys = $secretary[0]->user_type;
                // dd($secretarys);
                DB::commit();

                if ($save) {
                    Session::flash('success', 'Successfully added a new booking.');
                    return redirect()->route('myBooking');
                } else {
                    Session::flash('errors', ['' => 'Failed to add new booking, Please try again later']);
                    return redirect()->route('myBooking');
                }

                // end validate

            } else {
                Session::flash('error', 'You can not book at the hour you choose because there is already a booking between the hours you choose.');
                return redirect()->route('bookNow');
            }
        } else {
            Session::flash('error', 'You can not book because minimum start time is 5 minutes from now.');
            return redirect()->route('bookNow');
        }


        // kondisi : meeting tidak bisa terbook karena Waktu mulai minimum adalah 5 menit dari sekarang
        // jadi misal jam sekarang 13:00 berarti mulai meeting harus lebih dari 5 menit dari jam 13:00 yaitu 13:05

    }

    public function updateMybooking(Request $request, $id)
    {
        $rules = [
            'h_start'           => 'required',
            'h_end'             => 'required',
        ];

        $messages = [
            'h_start.required'      => 'h_start is required',
            'h_end.required'    => 'h_end is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $raw_h_start = $request->h_start;
        $raw_h_end = $request->h_end;
        $h_start = date('Y-m-d') . ' ' . $raw_h_start;
        $h_end = date('Y-m-d') . ' ' . $raw_h_end;
        // dd($h_start, $h_end);

        $timeUpdate = DB::update("UPDATE t_booking_rooms SET h_start = '$h_start', h_end = '$h_end' WHERE id ='$id' ");
        // dd($timeUpdate);

        if ($timeUpdate) {
            Session::flash('success', 'Successfully Update Mybooking.');
            return redirect()->route('myBooking');
        } else {
            Session::flash('errors', ['' => 'Failed to update Mybooking, Please try again later']);
            return redirect()->route('myBooking');
        }
    }

    public function view_mybooking($id)
    {

        $now = date('Y-m-d 00:00:00');

        $room = DB::select("SELECT room_id FROM t_booking_rooms WHERE id='$id'");
        // dd($room);
        $id_room = $room[0]->room_id;

        $list = DB::select("SELECT * from t_booking_rooms  where room_id='$id_room' AND meeting_date='$now'");
        // dd($list);


        // this is
        $pic = DB::select("SELECT
                t_booking_rooms.id AS id,
                users.name AS pic_name,
                users.email AS pic_email,
                users.phone AS pic_phone
            FROM
                t_booking_rooms
            INNER JOIN
                users
            ON t_booking_rooms.user_id = users.id
            WHERE t_booking_rooms.id =" . $id);

        $books = BookNow::find($id);

        $participants = BookNowParticipant::All()->where('book_id', $id);

        $fnbs = DB::select("SELECT
            t_booking_fnb.id AS id,
            menus.name AS name,
            t_booking_fnb.qty AS qty,
            t_booking_fnb.notes AS notes
        FROM
            t_booking_fnb
        INNER JOIN
            menus
        ON t_booking_fnb.menu_id = menus.id
        WHERE t_booking_fnb.book_id =" . $id);

        $room = DB::select("SELECT
        rooms.id AS room_id,
        rooms.name AS room_name,
        rooms.capacity AS capacity,
        room_images.img AS img
        FROM
        rooms
            INNER JOIN
        room_images ON rooms.id = room_images.id_room
        WHERE rooms.id = $books->room_id
        ");

        $facilities = DB::select("SELECT
        room_facilities.id,
        facilities.name AS name,
        room_facilities.device_id
        FROM
        room_facilities
        INNER JOIN
        facilities
        ON room_facilities.id_facility = facilities.id
        WHERE room_facilities.id_room = $books->room_id
        ");

        return view('Booking._mybookingView', compact('pic', 'books', 'participants', 'fnbs', 'room', 'facilities', 'list'));
    }

    public function view($id)
    {
        $books = BookNow::find($id);

        $now = date('Y-m-d 00:00:00');

        $nows = date('H:i:00');

        $room = DB::select("SELECT * FROM t_booking_rooms WHERE id='$id'");
        $id_room = $room[0]->room_id;
        $h_start = $room[0]->h_start;
        $date = $room[0]->meeting_date;

        $h_time = date('H:i:s', strtotime($h_start));

        $minTime = DB::select("SELECT ADDDATE('$h_start', INTERVAL - 239 MINUTE) as min;");
        $min = $minTime[0]->min;

        $maxTime = DB::select("SELECT ADDDATE('$h_start', INTERVAL -1 MINUTE) as max;");
        $max = $maxTime[0]->max;
        // dd($h_start, $max);

        // $tanggal = Carbon::now();
        // $hitung = DB::select("SELECT ADDDATE('$tanggal', INTERVAL -120 MINUTE) AS time");


        $tis = DB::select("SELECT * from t_booking_rooms  where room_id='$id_room' AND h_start between '$min' and '$max'  order by h_start;");
        // dd($tis);
        // $tis = DB::select("SELECT * FROM t_booking_rooms WHERE room_id='$id_room' AND h_start='$h_start' - INTERVAL 30 MINUTE;");


        $pic = DB::select("SELECT
                t_booking_rooms.id AS id,
                users.name AS pic_name,
                users.email AS pic_email,
                users.phone AS pic_phone
            FROM
                t_booking_rooms
            INNER JOIN
                users
            ON t_booking_rooms.user_id = users.id
            WHERE t_booking_rooms.id =" . $id);
        $participants = BookNowParticipant::All()->where('book_id', $id);

        $fnbs = DB::select("SELECT
            t_booking_fnb.id AS id,
            menus.name AS name,
            t_booking_fnb.qty AS qty,
            t_booking_fnb.notes AS notes
        FROM
            t_booking_fnb
        INNER JOIN
            menus
        ON t_booking_fnb.menu_id = menus.id
        WHERE t_booking_fnb.book_id =" . $id);

        $room = DB::select("SELECT
                rooms.id AS room_id,
                rooms.name AS room_name,
                rooms.capacity AS capacity,
                room_images.img AS img
            FROM
                rooms
                    INNER JOIN
                room_images ON rooms.id = room_images.id_room
            WHERE rooms.id = $books->room_id
        ");

        $facilities = DB::select("SELECT
                room_facilities.id,
                facilities.name AS name,
                room_facilities.device_id
            FROM
                room_facilities
                INNER JOIN
                facilities
                ON room_facilities.id_facility = facilities.id
            WHERE room_facilities.id_room = $books->room_id
        ");
        return view('Booking._viewMyBook', compact('books', 'pic', 'participants', 'fnbs', 'room', 'facilities', 'tis', 'now', 'date', 'nows', 'h_time'));
    }

    public function edit($id)
    {
        $books = BookNow::find($id);
        // $idTrx = $request->id;
        $book_id = $id;
        $pic = DB::select("SELECT
                t_booking_rooms.id AS id,
                users.id AS pic_id,
                users.name AS pic_name,
                users.email AS pic_email,
                users.phone AS pic_phone
            FROM
                t_booking_rooms
            INNER JOIN
                users
            ON t_booking_rooms.user_id = users.id
            WHERE t_booking_rooms.id =" . $id);
        $participants = BookNowParticipant::All()->where('book_id', $id);

        $fnbs = DB::select("SELECT
            t_booking_fnb.id AS id,
            t_booking_fnb.menu_id AS menu_id,
            menus.name AS name,
            t_booking_fnb.qty AS qty,
            t_booking_fnb.notes AS notes
        FROM
            t_booking_fnb
        INNER JOIN
            menus
        ON t_booking_fnb.menu_id = menus.id
        WHERE t_booking_fnb.book_id =" . $id);

        $room = DB::select("SELECT
                rooms.id AS room_id,
                rooms.name AS room_name,
                rooms.capacity AS capacity,
                room_images.img AS img
            FROM
                rooms
                    INNER JOIN
                room_images ON rooms.id = room_images.id_room
            WHERE rooms.id = $books->room_id
        ");

        $facilities = DB::select("SELECT
                room_facilities.id,
                facilities.name AS name,
                room_facilities.device_id
            FROM
                room_facilities
                INNER JOIN
                facilities
                ON room_facilities.id_facility = facilities.id
            WHERE room_facilities.id_room = $books->room_id
        ");

        $menus = DB::select("SELECT
                menus.id AS id,
                menus.name AS name,
                menu_cats.name AS category,
                menus.status AS status,
                menus.created_at AS created,
                menus.updated_at AS updated
            FROM
                menus
                    INNER JOIN
                menu_cats ON menus.id_cat = menu_cats.id
            WHERE menus.status = 1
            ORDER BY menus.created_at ASC
        ");
        return view('Booking._editMyBook', compact('books', 'pic', 'participants', 'fnbs', 'room', 'menus', 'facilities', 'book_id'));
    }

    public function update(Request $request)
    {
        $book_id = $request->book_id;

        $books = DB::select("SELECT
                *
            FROM
                t_booking_rooms
                    LEFT JOIN
                (SELECT
                    book_id,
                        SUM(is_present) AS total_present,
                        CONCAT('[', GROUP_CONCAT(JSON_OBJECT('name', name, 'email', email)), ']') AS parti_list
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
                    users.email AS pic_email,
                        users.name AS pic_name,
                        users.id AS pic_id
                FROM
                    users) pic ON pic.pic_id = t_booking_rooms.user_id
            WHERE
                id = '" . $book_id . "'
        ");

        // dd($books);
        $todaymeetingstamp = strtotime($books[0]->meeting_date);
        $todaystamp = gmdate('Ymd\THis\Z', $todaymeetingstamp);

        $startmeetingstamp = strtotime($books[0]->h_start);
        $startTime = gmdate('Ymd\THis\Z', $startmeetingstamp);

        $endmeetingstamp = strtotime($books[0]->h_end);
        $endTime =  gmdate('Ymd\THis\Z', $endmeetingstamp);

        $ics = array(
            "BEGIN:VCALENDAR",
            "VERSION:2.0",
            "PRODID:-//Google Inc//Google Calendar 70.9054//EN",
            "CALSCALE:GREGORIAN",
            "METHOD:REQUEST",
            "BEGIN:VEVENT",
            "UID:" . $books[0]->uid_meeting,
            "SUMMARY:" . $books[0]->desc,
            "LOCATION:" . $books[0]->address,
            "STATUS:CANCELLED",
            "DTSTART:" . $startTime,
            "DTEND:" . $endTime,
            "DTSTAMP:" . $startTime,
            "DTSTAMP:2020608T000000Z",
            "ATTENDEE;RSVP=TRUE;ROLE=REQ-PARTICIPANT:mailto:" . $books[0]->pic_email,
            // "ORGANIZER;CN=Smart Office MRT Jakarta:mailto:smartoffice@jakartamrt.co.id",
            "ORGANIZER;CN=Smart Office MRT Jakarta:mailto:smartofficemrt@gmail.com",
            "BEGIN:VALARM",
            "ACTION:DISPLAY",
            "DESCRIPTION:Meeting cancelled",
            "TRIGGER:-PT30M",
            "END:VALARM",
            "END:VEVENT",
            "END:VCALENDAR",
        );
        $ics = implode("\r\n", $ics);

        $parti_list = json_decode($books[0]->parti_list);
        // dd($parti_list);
        if ($parti_list != null) {
            foreach ($parti_list as $emailTo) {
                $email_data['event'] = $ics;
                $email_data['to'] = $emailTo->email;
                Mail::send('Mail._cancelEdit', compact('books', 'emailTo'), function ($message) use ($email_data) {
                    $message->to($email_data['to'])
                        ->subject('Meeting cancelled')
                        ->attachData($email_data['event'], 'invite.ics', [
                            'mime' => 'text/calendar;charset=UTF-8;method=REQUEST;name=invite.ics',
                        ]);
                });
            }
        }

        // DB::table('t_booking_rooms')->where('id', $book_id)->delete();
        DB::table('t_booking_fnb')->where('book_id', $book_id)->delete();
        DB::table('t_booking_participants')->where('book_id', $book_id)->delete();

        $user_id = $request->user_id;
        $meeting_date = $request->meeting_date;
        $h_start_dom = $request->h_start;
        $h_end_dom = $request->h_end;
        $h_start = $meeting_date . ' ' . $h_start_dom;
        $h_end = $meeting_date . ' ' . $h_end_dom;
        $room_id = $request->room_id;
        $room_name = $request->room_name;
        $room_capacity = $request->room_capacity;
        $desc = $request->desc;
        $status = $request->status;

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uid_meet = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];
        $string = str_shuffle($uid_meet);

        $checkIsApprove = DB::select(
            'SELECT
                t_booking_rooms.room_id AS room_id,
                rooms.is_need_approve AS approve
            FROM t_booking_rooms
            INNER JOIN
                rooms
            ON t_booking_rooms.room_id = rooms.id
            WHERE t_booking_rooms.id =' . $book_id
        );

        if ($checkIsApprove[0]->approve == 1) {
            $bookStatus = 9;
        } else if ($checkIsApprove[0]->approve == 2) {
            $bookStatus = 1;
        }

        DB::beginTransaction();
        DB::update("UPDATE t_booking_rooms
                set updated_at = now(),
                    room_id = '" . $room_id . "',
                    room_name = '" . $room_name . "',
                    room_capacity = '" . $room_capacity . "',
                    meeting_date = '" . $meeting_date . "',
                    h_start = '" . $h_start . ":00',
                    h_end = '" . $h_end . ":00',
                    `desc` = '" . $desc . "',
                    status = '" . $bookStatus . "'
                where id = '" . $book_id . "'
            ");


        $participants = [];
        // dd($request->guest_name);
        foreach ($request->guest_name as $key => $val) {
            if ($request->guest_email[$key] != null) {
                $code = QrCode::format('png')->size(512)->margin(2)->generate($request->guest_email[$key]);
                $participant = new BookNowParticipant;
                $participant->book_id = $book_id;
                $participant->name = $request->guest_name[$key];
                $participant->email = $request->guest_email[$key];
                $participant->company = $request->guest_company[$key];
                $participant->phone = $request->guest_phone[$key];
                $participant->status = $request->status[$key];
                $participant->img = 'data:image/png;base64,' . base64_encode($code);
                array_push($participants, $participant);
                $save = $participant->save();
            }
        }

        if ($request->menu_id != null) {
            $menus = [];
            foreach ($request->menu_id as $key => $val) {
                if ($request->qty[$key] != null) {
                    $menu = new BookNowFnB;
                    $menu->book_id = $book_id;
                    $menu->menu_id = $request->menu_id[$key];
                    $menu->qty = $request->qty[$key];
                    $menu->notes = ucwords(strtolower($request->notes[$key]));
                    $menu->status = $request->status[$key];
                    array_push($menus, $menu);
                    // dd($menus);
                    $save = $menu->save();
                    // dd($save);
                }
            }
        }
        DB::commit();



        return redirect()->route('myBooking');
    }

    public function cancel($id)
    {
        $books = DB::select("SELECT
                *
            FROM
                t_booking_rooms
                    LEFT JOIN
                (SELECT
                    book_id,
                        SUM(is_present) AS total_present,
                        CONCAT('[', GROUP_CONCAT(JSON_OBJECT('name', name, 'email', email)), ']') AS parti_list
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
                    users.email AS pic_email,
                        users.name AS pic_name,
                        users.id AS pic_id
                FROM
                    users) pic ON pic.pic_id = t_booking_rooms.user_id
            WHERE
                id = '" . $id . "'
        ");
        $todaymeetingstamp = strtotime($books[0]->meeting_date);
        $todaystamp = gmdate('Ymd\THis\Z', $todaymeetingstamp);

        $startmeetingstamp = strtotime($books[0]->h_start);
        $startTime = gmdate('Ymd\THis\Z', $startmeetingstamp);

        $endmeetingstamp = strtotime($books[0]->h_end);
        $endTime =  gmdate('Ymd\THis\Z', $endmeetingstamp);

        $ics = array(
            "BEGIN:VCALENDAR",
            "VERSION:2.0",
            "PRODID:-//Google Inc//Google Calendar 70.9054//EN",
            "CALSCALE:GREGORIAN",
            "METHOD:REQUEST",
            "BEGIN:VEVENT",
            "UID:" . $books[0]->uid_meeting,
            "SUMMARY:" . $books[0]->desc,
            "LOCATION:" . $books[0]->address,
            "STATUS:CANCELLED",
            "DTSTART:" . $startTime,
            "DTEND:" . $endTime,
            "DTSTAMP:" . $startTime,
            "ATTENDEE;RSVP=TRUE;ROLE=REQ-PARTICIPANT:mailto:" . $books[0]->pic_email,
            // "ORGANIZER;CN=Smart Office MRT Jakarta:mailto:smartoffice@jakartamrt.co.id",
            "ORGANIZER;CN=Smart Office MRT Jakarta:mailto:smartofficemrt@gmail.com",
            "BEGIN:VALARM",
            "ACTION:DISPLAY",
            "DESCRIPTION:Meeting cancelled",
            "TRIGGER:-PT30M",
            "END:VALARM",
            "END:VEVENT",
            "END:VCALENDAR",
        );

        $ics = implode("\r\n", $ics);
        $parti_list = json_decode($books[0]->parti_list);
        if ($parti_list != null) {
            // dd($parti_list);
            foreach ($parti_list as $emailTo) {
                $email_data['event'] = $ics;
                $email_data['to'] = $emailTo->email;
                Mail::send('Mail._cancelEdit', compact('books', 'emailTo'), function ($message) use ($email_data) {
                    $message->to($email_data['to'])
                        ->subject('Meeting cancelled')
                        ->attachData($email_data['event'], 'cancel.ics', [
                            'mime' => 'text/calendar; charset="utf-8"; method=REQUEST;',
                        ]);
                });
            }
        }
        DB::update("UPDATE t_booking_rooms SET status = 0 WHERE id =" . $id);
        DB::update("UPDATE t_booking_fnb SET status = 0 WHERE book_id =" . $id);
        DB::update("UPDATE t_booking_participants SET status = 0 WHERE book_id =" . $id);
        // DB::table('t_booking_fnb')->where('book_id', $id)->delete();
        // DB::table('t_booking_participants')->where('book_id', $id)->delete();
        Session::flash('success', 'Your booking has been successfully canceled.');
        return redirect()->route('myBooking');
    }

    public function delete($id)
    {
        DB::table('t_booking_rooms')->where('id', $id)->delete();
        DB::table('t_booking_fnb')->where('book_id', $id)->delete();
        DB::table('t_booking_participants')->where('book_id', $id)->delete();
        Session::flash('success', 'Your booking has been successfully deleted.');
        return redirect()->route('myBooking');
    }
}
