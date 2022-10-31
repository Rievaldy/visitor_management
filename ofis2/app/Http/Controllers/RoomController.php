<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Validator;
use Session;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Location;
use App\Models\RoomDay;
use App\Models\Facility;
use App\Models\Report_dashboard;
use App\Models\RoomFacility;
use App\Models\RoomImage;
use DB;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        // $rooms = Room::All();
        $rooms = DB::table('rooms')
            ->orderBy('name', 'ASC')
            ->get();
        $days = DB::select("SELECT
                room_days.id,
                room_days.room_id,
                room_days.day_name AS day_name,
                rooms.id
            FROM
                rooms
                    INNER JOIN
                room_days ON room_days.room_id = rooms.id");
        // dd($days);
        return view('MeetingRoom.index', compact('rooms', 'days'));
    }

    public function addRoom()
    {
        $locations = DB::table('locations')
            ->orderBy('locations.created_at', 'ASC')
            ->get();
        $facilities = DB::table('facilities')
            ->orderBy('facilities.created_at', 'ASC')
            ->get();
        return view('MeetingRoom._add', compact('locations', 'facilities'));
    }

    public function storeRoom(Request $request)
    {
        $rules = [
            'name'                      => 'required|unique:rooms,name|min:3|max:50',
            'capacity'                  => 'required',
            'id_loc'                    => 'required',
            'h_avail'                   => 'required',
            'h_start'                   => 'required',
            'h_end'                     => 'required',
            'day_avail'                 => 'required',
            'status'                    => 'required',
            'room_call_id'              => 'required',
            'is_need_approve'           => 'required',
            'is_ds_mirror'              => 'required',
            // 'is_ds_reader'              => 'required',
            'asset_code.unique'         => 'Asset Code has already exist',
            'device_id.unique'          => 'Device ID has already exist',
        ];

        $messages = [
            'name.required'             => 'Room name is required',
            'name.min'                  => 'Room name of at least 3 characters',
            'name.max'                  => 'Room name up to 50 characters',
            // 'name.unique'               => 'Room name has already exist',
            'capacity.required'         => 'Capacity is required',
            'id_loc.required'           => 'Room location is required',
            'h_avail.required'          => 'Hour availbality is required',
            'h_start.required'          => 'Start hour is required',
            'h_end.required'            => 'End hour is required',
            'day_avail.required'        => 'Day availbality is required',
            'asset_code'                => 'unique:room_facilities,asset_code',
            'device_id'                 => 'unique:room_facilities,device_id',
            'room_call_id.required'     => 'Chat secretary is required',
            'is_need_approve.required'  => 'Room use approval is required',
            'is_ds_mirror.required'     => 'Camera type is required',
            // 'is_ds_reader.required'     => 'Scanner type is required',
            'status.required'           => 'Status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $allDays = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        $weekDays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');

        DB::beginTransaction();
        $room = new Room;
        $room->name = ($request->name);
        $room->capacity = ($request->capacity);
        $room->id_loc = ($request->id_loc);
        $room->h_avail = ($request->h_avail);
        $room->h_start = new DateTime($request->h_start);
        $room->h_end = new DateTime($request->h_end);
        $room->day_avail = ($request->day_avail);
        $room->room_call_id = ($request->room_call_id);
        $room->is_need_approve = ($request->is_need_approve);
        $room->is_ds_mirror = ($request->is_ds_mirror);
        $room->is_ds_reader = ($request->is_ds_reader);
        $room->status = ($request->status);
        $save = $room->save();

        if ($room->day_avail == 1) {
            foreach ($allDays as $allDay) {
                $x = new RoomDay;
                $x->room_id = $room->id;
                $x->day_name = ucwords(strtolower($allDay));
                $save = $x->save();
            }
        } else if ($room->day_avail == 2) {
            foreach ($weekDays as $weekDay) {
                $x = new RoomDay;
                $x->room_id = $room->id;
                $x->day_name = ucwords(strtolower($weekDay));
                $save = $x->save();
            }
        } else if ($room->day_avail == 3) {
            foreach ($request->day_name as $day) {
                $x = new RoomDay;
                $x->room_id = $room->id;
                $x->day_name = ucwords(strtolower($day));
                $save = $x->save();
            }
        }
        if ($request->id_facility != null) {
            foreach ($request->id_facility as $key => $val) {
                if ($request->device_id[$key] != null) {
                    $y = new RoomFacility;
                    $y->id_room = $room->id;
                    $y->property_name = $request->property_name[$key];
                    $y->id_facility = $request->id_facility[$key];
                    $y->asset_code = $request->asset_code[$key];
                    $y->device_id = $request->device_id[$key];
                    $save = $y->save();
                }
            }
        }
        if ($request->file('img') != null) {
            $z = new RoomImage;
            $z->id_room = $room->id;
            $z->img = 'data:image/png;base64,' . base64_encode(file_get_contents($request->file('img')));;
            $save = $z->save();
        }
        DB::commit();
        // dd($save);
        $user_id = Auth::user()->id;
        $pesan = 'Added room';
        if ($save == true) {
            $dashboard = new Report_dashboard;
            $dashboard->user_id = $user_id;
            $dashboard->action = $pesan;
            $saves = $dashboard->save();
        }

        if ($save) {
            Session::flash('success', 'Successfully added a new room.');
            return redirect()->route('rooms');
        } else {
            Session::flash('errors', ['' => 'Failed to add new room, Please try again later']);
            return redirect()->route('rooms');
        }
    }

    public function editRoom($id)
    {
        $rooms = Room::find($id);
        // dd($rooms);
        $locations = DB::table('locations')
            ->orderBy('locations.created_at', 'ASC')
            ->get();

        $facilities = DB::table('facilities')
            ->orderBy('facilities.created_at', 'ASC')
            ->get();
        // dd($facilities);

        $activeFacility = DB::select("SELECT
                    room_facilities.id_room,
                    room_facilities.id_facility,
                    room_facilities.property_name,
                    facilities.name AS name,
                    room_facilities.device_id,
                    room_facilities.asset_code
                FROM
                    room_facilities
                    INNER JOIN
                    facilities  ON room_facilities.id_facility = facilities.id
                WHERE room_facilities.id_room = $id
            ");
        // dd($activeFacility);
        $room_image = DB::select(
            "SELECT
                rooms.id AS room_id,
                room_images.img AS img
            FROM
                rooms
                    INNER JOIN
                room_images ON rooms.id = room_images.id_room
            WHERE rooms.id =" . $id
        );
        return view('MeetingRoom._edit', compact('rooms', 'room_image', 'facilities', 'activeFacility', 'locations'));
    }

    public function updateRoom(Request $request, $id)
    {
        $allDays = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        $weekDays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');

        DB::beginTransaction();
        $room = Room::find($id);
        $room->name = ucwords(strtolower($request->name));
        $room->capacity = ($request->capacity);
        $room->id_loc = ($request->id_loc);
        $room->h_avail = ($request->h_avail);
        $room->h_start = new DateTime($request->h_start);
        $room->h_end = new DateTime($request->h_end);
        $room->day_avail = ($request->day_avail);
        $room->room_call_id = ($request->room_call_id);
        $room->is_need_approve = ($request->is_need_approve);
        $room->is_ds_mirror = ($request->is_ds_mirror);
        $room->is_ds_reader = ($request->is_ds_reader);
        $room->status = ($request->status);
        $save = $room->save();
        if ($room->day_avail == 1) {
            DB::table('room_days')->where('room_id', $id)->delete();
            foreach ($allDays as $allDay) {
                $x = new RoomDay;
                $x->room_id = $id;
                $x->day_name = ucwords(strtolower($allDay));
                $save = $x->save();
            }
        } else if ($room->day_avail == 2) {
            DB::table('room_days')->where('room_id', $id)->delete();
            foreach ($weekDays as $weekDay) {
                $x = new RoomDay;
                $x->room_id = $id;
                $x->day_name = ucwords(strtolower($weekDay));
                $save = $x->save();
            }
        } else if ($room->day_avail == 3) {
            if ($request->day_name != null) {
                DB::table('room_days')->where('room_id', $id)->delete();
                foreach ($request->day_name as $day) {
                    $x = new RoomDay;
                    $x->room_id = $id;
                    $x->day_name = ucwords(strtolower($day));
                    $save = $x->save();
                }
            }
        }

        if ($request->id_facility != null) {
            DB::table('room_facilities')->where('id_room', $id)->delete();
            foreach ($request->id_facility as $key => $val) {
                if ($request->device_id[$key] != null) {
                    $y = new RoomFacility;
                    $y->id_room = $id;
                    $y->id_facility = $request->id_facility[$key];
                    $y->property_name = $request->property_name[$key];
                    $y->asset_code = $request->asset_code[$key];
                    $y->device_id = $request->device_id[$key];
                    $save = $y->save();
                }
            }
        }


        if ($request->file('img') != null) {
            DB::table('room_images')->where('id_room', $id)->delete();
            $z = new RoomImage;
            $z->id_room = $id;
            $z->img = 'data:image/png;base64,' . base64_encode(file_get_contents($request->file('img')));;
            $save = $z->save();
        }
        DB::commit();
        $user_id = Auth::user()->id;
        $pesan = 'Updated room';
        if ($save == true) {
            $dashboard =  new Report_dashboard;
            $dashboard->user_id = $user_id;
            $dashboard->action = $pesan;
            $saves = $dashboard->save();
        }
        return redirect()->route('rooms');
    }

    public function deleteRoom($id)
    {
        $data = DB::table('rooms')->where('id', $id)->delete();
        // dd($data);
        $user_id = Auth::user()->id;
        $pesan = 'Deleted room';

        if ($data == 1) {
            $dashboard = new Report_dashboard;
            $dashboard->user_id = $user_id;
            $dashboard->action = $pesan;
            $saves = $dashboard->save();
        }
        Session::flash('success', 'Room has been successfully deleted.');
        return redirect()->route('rooms');
    }
}
