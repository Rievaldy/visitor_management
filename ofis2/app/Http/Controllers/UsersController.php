<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;
use DB;
use Mail;
use View;

class UsersController extends Controller
{
    public function index()
    {
//        $users = DB::select("SELECT
//                a.*,
//                b.name AS dir_name,
//                c.name AS div_name,
//                d.name AS dep_name
//            FROM
//                users a
//                    LEFT JOIN
//                users_directorate b ON a.id_dir = b.id
//                    LEFT JOIN
//                users_division c ON a.id_div = c.id
//                    LEFT JOIN
//                users_department d ON a.id_dep = d.id
//        ");

        //return view('User.index', compact('users'));
        return view('User.index');
    }

    public function getAllUsers(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        $users = DB::table('users')->
        leftJoin('users_department', 'users.id_dep', '=', 'users_department.id')->
        select('users.id', 'users.employee_id', 'users.name', 'users.email', 'users.password', 'users.phone', 'users.company', 'users.user_type', 'users.user_grade',  'users.img', 'users.status', 'users.remember_token', 'users.email_verified_at', 'users.created_at', 'users.updated_at', 'users_department.name AS dep_name')->
        orderBy($columnName,$columnSortOrder)->skip($start)->take($rowperpage)->
        where('users.name', 'like', '%' .$searchValue . '%')->
        orWhere('users.email', 'like', '%' .$searchValue . '%')->
        orWhere('users.phone', 'like', '%' .$searchValue . '%')->
        orWhere('users.company', 'like', '%' .$searchValue . '%')->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($users as $user){
            $displayUserType = "";
            if($user->user_type == 99){
                $displayUserType = 'Administrator';
            } else if ($user->user_type == 1) {
                $displayUserType = 'GA/Security';
            }else if ($user->user_type == 2) {
                $displayUserType = 'PIC Project/Purchasing/YKK Employee';
            }else if ($user->user_type == 3) {
                $displayUserType = 'HSE Management';
            }else if ($user->user_type == 4) {
                $displayUserType = 'Confidential Management';
            } else if ($user->user_type == 5) {
                $displayUserType = 'Factory Director';
            }
            $data_arr[] = array(
                "id" => $user->id,
                "employee_id" =>$user->employee_id,
                "name" => $user->name,
                "email" => $user->email,
                "company" => $user->company,
                "phone" => $user->phone,
                "user_type" => array(
                    "display" => $displayUserType,
                    "user_type" => $user->user_type
                ),
                "status" => array(
                    "display" => $user->status  == 1 ? "Active":"Inactive",
                    "status" => $user->status
                ),
                "updated_at" => $user->updated_at
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        //return view('User.index', compact('users'));
        echo json_encode($response);
        exit;
    }

    public function getUserByIdEmployee(Request $request){
        $id = $request->id;
        $user = DB::table('users')->
        leftJoin('users_department', 'users.id_dep', '=', 'users_department.id')->
        select('users.id', 'users.employee_id', 'users.name', 'users.email', 'users.password', 'users.phone', 'users.company', 'users.user_type', 'users.user_grade',  'users.img', 'users.status', 'users.remember_token', 'users.email_verified_at', 'users.created_at', 'users.updated_at', 'users_department.name AS dep_name')->
        where('users.id', $id)->get();
        //dd($user);
        $response = array(
            "employee_id" =>$user[0]->employee_id,
            "name" => $user[0]->name,
            "email" => $user[0]->email,
            "company" => $user[0]->company,
            "phone" => $user[0]->phone,
            "user_type" => $user[0]->user_type,
            "user_grade" => $user[0] ->user_grade,
            "img" => $user[0] ->img,
            "dep_name" => $user[0] ->dep_name,
            "status" => $user[0]->status,
            "updated_at" => $user[0]->updated_at
        );
        return response()->json($response);
    }

    public function _getDepartment()
    {
        $list = DB::select("SELECT id AS id, name AS text FROM users_department");
        return response()->json($list);
    }

    public function add()
    {
        $userDep = DB::select("SELECT * FROM users_department");
        return view('User._add', compact('userDep'));
    }

    public function store(Request $request)
    {
        // validasi phone number
        $data = DB::select("SELECT phone FROM users WHERE phone = '$request->phone'");
        if (count($data) > 0) {
            return redirect('userAdd')->with(['error' => 'The number you entered has been registered']);
        } else {
            $phone = $request->phone;
        }

        // // validasi email
        // $data_email = DB::select("SELECT email FROM users WHERE email ='$request->email'");
        // if (count($data_email) > 0) {
        //     return redirect('userAdd')->with(['error' => 'The email you entered has been registered']);
        // } else {
        //     $email = $request->email;
        // }

        //validasi employee id
        $data_employee = DB::select("SELECT employee_id FROM users WHERE employee_id='$request->employee_id'");
        if (count($data_employee)) {
            return redirect('userAdd')->with(['error' => 'The employee id you entered has been regisered']);
        } else {
            $employee_id = $request->employee_id;
        }


        $rules = [
            'employee_id'                   => 'required|unique:users,employee_id',
            'name'                          => 'required|min:3|max:35',
            'email'                         => 'required|email|unique:users,email',
            'company'                       => 'required',
            'phone'                         => 'required|unique:users,email|numeric',
            'user_type'                     => 'required',
            'img'                           => 'required',
        ];

        $messages = [
            'employee_id.required'          => 'Employee ID is required',
            'name.required'                 => 'Full name is required',
            'name.min'                      => 'Full name of at least 3 characters',
            'name.max'                      => 'Full name up to 35 characters',
            'email.required'                => 'Email is required',
            'email.email'                   => 'Email is not valid',
            'email.unique'                  => 'Email already registered',
            'phone.required'                => 'Phone is required',
            'user_type.required'            => 'User type is required',
            'company.required'              => 'Company is required',
            'img.required'                  => 'Employee photo is required
',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randPass = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        $user = new User;
        // $user->employee_id = ($request->employee_id);
        $user->employee_id = $employee_id;

        $user->email = strtolower($request->email);
        // $user->email = strtolower($email);

        $user->phone = $phone;
        // $user->phone = ($request->phone);

        $user->name = ucwords(strtolower($request->name));
        $user->company = ($request->company);
        $user->user_type = ($request->user_type);
        if ($request->type > 2 && $request->type < 6) {
            $user->user_grade = $request->user_grade;
            $user->id_dep = null;
        } elseif ($request->type == 2) {
            $user->user_grade = null;
            $user->id_dep = $request->id_dep;
        } else {
            $user->user_grade = null;
            $user->id_dep = null;
        }
        $user->password = Hash::make($randPass);
        $user->status = ($request->status);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->img = 'data:image/png;base64,' . base64_encode(file_get_contents($request->file('img')));
        // dd($employee_id, $email, $phone);
        $save = $user->save();

        $datas = DB::table('users')->latest('created_at')->first();
        // dd($datas->email);
        $email['to'] = $datas->email;
        Mail::send('Mail._welcome', compact('datas', 'randPass'), function ($message) use ($email) {
            // $message->from('no-reply@ofis.com', 'Smart Office MRT Jakarta');
            $message->to($email['to'])
                ->subject('Registration Complete');
        });
        if ($save) {
            Session::flash('success', 'Successfully added a new user!');
            return redirect()->route('userAdd');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('userAdd');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $userDep = DB::select("SELECT * FROM users_department");

        return view('User._edit', compact('user','userDep'));
    }

    public function update(Request $request, $id)
    {
        //validasi phone number
        $user = User::find($id);
        $check_phone = DB::select("SELECT phone FROM users WHERE phone='$request->phone'");

        if (count($check_phone) > 0) {
            if ($user->phone != $request->phone) {
                return redirect('user')->with(['error' => 'The phone number you entered has been registered']);
            } else {
                $phone = $request->phone;
            }
        } else {
            $phone = $request->phone;
        }

        //validasi email
        $user = User::find($id);
        $check_email = DB::select("SELECT email FROM users WHERE email='$request->email'");

        if (count($check_email) > 0) {
            if ($user->email != $request->email) {
                return redirect('user')->with(['error' => 'The email you entered has been registered']);
            } else {
                $email = $request->email;
            }
        } else {
            $email = $request->email;
        }

        //validasi employee id
        $user = User::find($id);
        $check_employee = DB::select("SELECT employee_id FROM users WHERE employee_id='$request->employee_id'");

        if (count($check_employee) > 0) {
            if ($user->employee_id != $request->employee_id) {
                return redirect('user')->with(['error' => 'The employee id you entered has been registered']);
            } else {
                $employee_id = $request->employee_id;
            }
        } else {
            $employee_id = $request->employee_id;
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'phone' => 'required',
            'user_type' => 'required',
            'status' => 'required',
            'password' => 'nullable',
        ]);

        $user = User::find($id);
        // $user->employee_id = $request->employee_id;
        $user->employee_id = $employee_id;
        $user->name = $request->name;
        // $user->email = $request->email;
        $user->email = $email;
        $user->company = $request->company;
        // $user->phone = $request->phone;
        $user->phone = $phone;
        $user->user_type = $request->user_type;
        if ($request->user_type > 2 && $request->user_type < 6) {
            $user->user_grade = $request->user_grade;
            $user->id_dep = null;
        } elseif ($request->user_type == 2) {
            $user->user_grade = null;
            $user->id_dep = $request->id_dep;
        } else {
            $user->user_grade = null;
            $user->id_dep = null;
        }
        $user->status = $request->status;
        if ($request->img) {
            $user->img = 'data:image/png;base64,' . base64_encode(file_get_contents($request->file('img')));
        }
        if ($request->password) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        Session::flash('success', 'User has been successfully updated.');
        return redirect()->route('user');
    }

    public function changePassword(Request $request, $id)
    {

        $user = User::find($id);
        $validatedData = $request->validate([
            'current_password' => 'nullable',
            'new_password'     => 'nullable',
            // 'pnew_password_confirm' => 'nullable|same:new_password'
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            return response()->json(['data' => 'Your password has been successfully updated.', 'status' => true], 200);
        } else {
            return response()->json(['data' => 'Error, Old password does not match', 'status' => false], 200);
        }
    }

    public function change()
    {
        // $user = User::find($id);

        // return view('User._changepass', compact('user'));
        return view('User._changepass');
    }

    public function delete($id)
    {
        $result = DB::table('users')->where('id', $id)->delete();
        if ($result) {
            $user['result'] = true;
            $user['message'] = "Customer Successfully Deleted!";
        } else {
            $user['result'] = false;
            $user['message'] = "Customer was not Deleted, Try Again!";
        }
        return json_encode($user, JSON_PRETTY_PRINT);
    }
}
