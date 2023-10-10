<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\tblcomp;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function registerView(){
        return view('displayRegister');
    }
    public function register(Request $request){
        $request->validate(
        [    
            'email' => 'required|email|unique:tbluser,email',
            'password' => 'required|min:6',
            'password2' => 'required|same:password',
            'nama' => 'required',
            'hp' => 'required',
            'alamatSingkat' => 'required',
            'alamatLengkap' => 'required',
            'infoTambahan' => 'nullable',
        ], 
        [    
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password2.required' => 'Password Tidak Sama.',
            'password.min' => 'Password minimal 6 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'hp.required' => 'Nomor HP wajib diisi.',
            'alamatSingkat.required' => 'Alamat singkat wajib diisi.',
            'alamatLengkap.required' => 'Alamat lengkap wajib diisi.',
        ]);


        $data = [
            'companyidArray' => '1,',
            'companyid' => null,
            'statusid' => 1,
            'email' => $request->email,
            'password' => hash::make($request->password),
            'nama' => $request->nama,
            'hp' => $request->hp,
            'alamatSingkat' => $request->alamatSingkat,
            'alamatLengkap' => $request->alamatLengkap,
            'infoTambahan' => $request->InfoTambahan,
            'profileImg' => "user/user.png",
        ];
        $data = tbluser::create($data);
        $data->update([
            'UserInsert' => $data->userid,
            'UserUpdate' => $data->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        $credentials = [
            'email' => $data->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            session_start();
            $request->session()->regenerate();
            session(['UIDGlob' => auth()->user()]);
            return redirect()->intended('/');
        }
        return redirect()->back();
    }

    public function forgot(){
        return view('displayForgot');
    }

    public function otp(Request $request){
        $user = tbluser::where('email',$request->email)->first();
        if(isset($user)){
            $otp = random_int(100000, 999999);
            $data = [
                'type' => 'otp',
                'name' => $user->nama,
                'otp' => $otp,
            ];
            Mail::to($user->email)->send(new SendMail($data));
            $user->update(['TokenOTP' => $otp,'OtpDT'=>Carbon::now()]);
            return $otp + 1234;
        }else{
            return 0;
        }
    }

    public function confirmotp(Request $request){
        $user = tbluser::where('email',$request->mail)->first();
        if($user->TokenOTP == $request->otp - 1234){
            $user->update(['password' => Hash::make($request->password),'TokenOTP' => 'Reset']);
            $credentials = [
                'email' => $request->mail,
                'password' => $request->password,
            ];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                session(['UIDGlob' => auth()->user()]);
                return redirect()->intended('/');
            }
        }
        return redirect()->back();
    }

    public function uploadimageprofile(Request $request)
    {
        if ($request->hasFile('image')) {
            $user = tbluser::find(session('UIDGlob')->userid);
            if ($user->profileImg != "user/user.png") {
                Storage::delete('public/'.$user->profileImg);
            }
            $file = $request->file('image');
            $exten = $file->getClientOriginalExtension();
            $path = $file->storeAs('public/user/'.session('UIDGlob')->userid, 'user.'.$exten);
            $user->update([
                'profileImg'=>'user/'.session('UIDGlob')->userid.'/'. 'user.'.$exten,
                'UserUpdate' => session('UIDGlob')->userid,
                'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
            Storage::url($path);
            $path = asset('public/storage/'.'user/'.session('UIDGlob')->userid. '/user.'.$exten);
            return $path;
        }
        return 0;
    }

    public function updateUser(Request $request){
        tbluser::find(session('UIDGlob')->userid)->update($request->all());
        return tbluser::where('userid', session('UIDGlob')->userid)
        ->select('nama', 'email', 'hp', 'alamatSingkat', 'alamatLengkap', 'infoTambahan')
        ->first();
    }

    public function changePass(Request $request){
        $user = tbluser::find(session('UIDGlob')->userid);

        // Validate password old
        if (!Hash::check($request->passwordold, $user->password)) {
            return 0;
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return 1;
    }

    public function companytouser(Request $request)
    {
        $request->tokenid;
        $companyid = session('UIDGlob')->companyid;

        if (isset($request->companyemail)) {
            $tblcomp = tblcomp::where('email', $request->companyemail)->first();
            $companyid = isset($tblcomp->companyid) ? $tblcomp->companyid : '';
        }

        if ($companyid != '') {
            $companyname = tblcomp::find($companyid)->companyname;
            $tbluser = tbluser::where('tokenid', $request->tokenid)->first();
            $companyarray = isset($tbluser->companyidArray) ? $tbluser->companyidArray : null;

            if (isset($tbluser)) {
                $companyIDArray = explode(',', $companyarray);
                if (in_array($companyid, $companyIDArray)) {
                    $msg = "Pengelola ".$companyname." Sudah ditambahkan";
                } else {
                    $tbluser->update(['companyidArray' => $companyarray . $companyid . ',']);
                    $msg = "Pengelola ".$companyname." Sudah ditambahkan";
                }
            } else {
                $msg = "Perusahaan Tidak Ditemukan";
            }
        } else {
            $msg = "Perusahaan Tidak Ditemukan";
        }
        $view = "
        <style>
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        
            h1 {
                color: #333;
            }
    
            p {
                color: #666;
            }
        </style>
        <div class='container'>
            <h1>".$msg."</h1>
            <p>Terima kasih</p>
        </div>";
            
        return $view;
    }
    public function usertocomp(Request $request)
    {
        if (isset($request->email)) {
            $tbluser = tbluser::where('email', $request->email)->first();
            $userid = isset($tbluser->userid) ? $tbluser->userid : '';
        }

        if ($userid != '' && $userid != session('UIDGlob')->userid) {
            $companyarray = isset($tbluser->companyidArray) ? $tbluser->companyidArray : null;
            $companyIDArray = explode(',', $companyarray);
            if (in_array(session('UIDGlob')->companyid, $companyIDArray)) {
                $msg = "Customer ".$tbluser->nama." Sudah ditambahkan";
            } else {
                $tbluser->update(['companyidArray' => $companyarray . session('UIDGlob')->companyid . ',']);
                $msg = "Customer ".$tbluser->nama." Sudah ditambahkan";
            }
        } else {
            $msg = "Customer Tidak Ditemukan";
        }
        $view = "
        <style>
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        
            h1 {
                color: #333;
            }
    
            p {
                color: #666;
            }
        </style>
        <div class='container'>
            <h1>".$msg."</h1>
            <p>Terima kasih</p>
        </div>";
    
        return $view;
    }
    public function updateTutor(){
        tbluser::find(session('UIDGlob')->userid)->update(['isTutor' => 0]);
        return 1;
    }
}
