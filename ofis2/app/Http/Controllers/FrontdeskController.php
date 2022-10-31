<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frontdesk;
use App\Models\BookNow;
use DB;
use Mail;

class FrontdeskController extends Controller
{
    public function index(){
        $datas = DB::select("SELECT
                t_frontdesk.*,
                rooms.name AS room_name
            FROM
                t_frontdesk
            INNER JOIN
                rooms
            ON t_frontdesk.room_id = rooms.id
            WHERE t_frontdesk.status = 1
            GROUP BY room_id
            ORDER BY room_name ASC
        ");
        return view('Frontdesk.index', compact('datas'));
    }

    public function view($id){
        $books = BookNow::find($id);
        $datas = DB::select("SELECT
                *
            FROM
                t_frontdesk
            WHERE book_id =".$id
        );
        return view('Frontdesk._view', compact('books', 'datas'));
    }

    public function update(Request $request, $id){
        // dd($request->book_id);
        $book_id = $request->book_id;
        $now = date('Y-m-d H:i:s');
        $updateStatus = 2;
        DB::table('t_frontdesk')->where('id', $id)->update(['t_frontdesk.status' => $updateStatus, 't_frontdesk.updated_at' => $now]);
        return redirect('frontdesk/view/'.$book_id);
    }

    public function instruction(Request $request){
        // dd($request->book_id, $request->room_id, $request->msg);
        $book_id = $request->book_id;
        $room_id = $request->room_id;
        $msg = $request->msg;

        $inst = new Frontdesk;
        $inst->book_id = $book_id;
        $inst->room_id = $room_id;
        $inst->msg = $msg;
        $save = $inst->save();


        if($save){
            $res = array(
                'code' => 200,
                'message' => 'Success'
            );
        } else {
            $res = array(
                'code' => 400,
                'message' => $error_msg
            );
        }

        $findDatas = DB::select("SELECT
            *
            FROM rooms
            WHERE id = '".$room_id."'
        ");

        // dd($findDatas[0]->name);

        $frontdesk = DB::select("SELECT
                name,
                email
            FROM users
            WHERE user_type = 1
        ");

        foreach ($frontdesk as $_front) {
            $email_data['to'] = $_front->email;
            $emailTo= new \stdClass();
            $emailTo->name = $_front->name;

            $room_name = $findDatas[0]->name;

            Mail::send('Mail._callFrontdesk', compact('emailTo', 'room_name', 'msg'), function($message) use ($email_data)
            {
                $message->to($email_data['to'])
                    ->subject('Call from Meeting Room');
            });
            $res = array(
                'code' => 200,
                'message' => 'sukses'
            );
        }
        return response()->json($res);
    }
}
