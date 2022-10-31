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

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di user nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('Dashboard');
        }
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string',
        ];

        $messages = [
            'email.required'        => 'Email is required.',
            'password.required'     => 'Password is required.',
            'password.string'       => 'Password must be string.',
            'email.email'           => 'Sorry, your account could not be found.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if ( Auth::check() && Auth::user()->status != 1 ) { // true sekalian session field di user nanti bisa dipanggil via Auth
            Auth::logout();
            Session::flash('error', 'Your account is inactive, please contact the Administrator.');
            return redirect()->route('loginForm');

        }
        else if( Auth::check() && Auth::user()->status == 1 ){
            //Login Success
            // dd(Auth::user());
            if(Auth::user()->user_type == 99){
                // return redirect()->route('dashboard');
                return redirect()->route('Dashboard');
            } else if (Auth::user()->user_type == 5) {
                // return redirect()->route('dashboard');
                return redirect()->route('Purchasing');
            }else if (Auth::user()->user_type == 1) {
                // return redirect()->route('dashboard');
                return redirect()->route('Purchasing');
            } else if (Auth::user()->user_type == 4) {
                // return redirect()->route('dashboard');
                return redirect()->route('Purchasing');
            } else if (Auth::user()->user_type == 3) {
                // return redirect()->route('dashboard');
                return redirect()->route('Purchasing');
            } else if (Auth::user()->user_type == 2) {
                // return redirect()->route('dashboard');
                return redirect()->route('fnbDashboard');
            } else if (Auth::user()->user_type == 20) {
                // dd(Auth::user());
                $rooms = DB::select("SELECT room_id
                    FROM room_atomation_controls
                    WHERE user_id = ".Auth::user()->id
                );
                $room_id = $rooms[0]->room_id;
                return redirect('device-control/'.$room_id);
            } else if (Auth::user()->user_type == 30) {
                // dd(Auth::user());
                $rooms = DB::select("SELECT room_id
                    FROM room_digital_signage
                    WHERE user_id = ".Auth::user()->id
                );
                $room_id = $rooms[0]->room_id;
                return redirect('digital-signage/'.$room_id);
            } else if (Auth::user()->user_type == 40) {
                return redirect()->route('visitorView');
            } else if (Auth::user()->user_type == 1) {
                return redirect()->route('bookNow');
            }

        } else { // false

            //Login Fail
            Session::flash('error', 'Incorrect em   ail or password.');
            return redirect()->route('loginForm');
        }

    }

    public function showFormRegister()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed',
            'phone'                 => 'required|numeric',
            'company'               => 'required',
        ];

        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'phone.required'        => 'Phone wajib diisi',
            'company.required'      => 'Company wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->company = ucwords(strtolower($request->company));
        $user->phone = ($request->phone);
        $user->user_type = ($request->user_type);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();

        if($simpan){
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('loginForm');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }

    public function showForgotPasword()
    {
        return view('Auth.forgot');
    }

    public function updateForgotPass(Request $request)
    {
        // $now = date('Y-m-d H:i:s');
        // $email = $request->email;
        // $datas = DB::select("SELECT * FROM users WHERE email = '".$email."'" );

        // if ($datas != null) {
        //     $validatedData = $request->validate([
        //         'email' => 'required',
        //     ]);

        //     $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //     $randPass = mt_rand(1000000, 9999999)
        //         . mt_rand(1000000, 9999999)
        //         . $characters[rand(0, strlen($characters) - 1)];

        //     DB::table('users')
        //         ->where('email', $email)
        //         ->update(['password' => Hash::make($randPass), 'updated_at' => $now ]);

        //     Mail::send('Mail._resetPass', compact('datas', 'randPass'), function($message) use ($email)
        //     {
        //         $message->from('no-reply@ofis.com', 'Smart Office MRT Jakarta');
        //         $message->to($email)
        //             ->subject('Reset password');
        //     });

        //     Session::flash('success', 'New password has been sent to your email');
        //     return redirect()->route('login');
        // } else {
        //     Session::flash('errors', ['' => 'Alamat email tidak ditemukan']);
        //     return redirect()->route('resetPass');
        // }
        $now = date('Y-m-d H:i:s');
        $email = $request->email;
        $datas = User::where('email', '=', $email)->first();
        // dd($datas);
        if($datas == null){
            Session::flash('errors', ['' => 'Alamat email tidak ditemukan']);
            return redirect()->route('forgot');
        } else {
            $validatedData = $request->validate([
                'email' => 'required',
            ]);

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randPass = mt_rand(1000000, 9999999)
                . mt_rand(1000000, 9999999)
                . $characters[rand(0, strlen($characters) - 1)];

            DB::table('users')
                ->where('email', $email)
                ->update(['password' => Hash::make($randPass), 'updated_at' => $now ]);

            Mail::send('Mail._resetPass', compact('datas', 'randPass'), function($message) use ($email)
            {
                // $message->from('no-reply@ofis.com', 'Smart Office MRT Jakarta');
                $message->to($email)
                    ->subject('Reset password');
            });

            Session::flash('success', 'New password has been sent to your email');
            return redirect()->route('loginForm');
        }

    }

    public function logout(Request $request)
    {
        Auth::logout(); // menghapus session yang aktif
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginForm');
    }
}
