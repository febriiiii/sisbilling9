<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\tblcomp;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    public function companyUpdate(Request $request){
        $cek = tblcomp::where('email',$request->email)->first();
        if(isset($cek->email)){
            if(session('UIDGlob')->companyid == null){
                return "Email Sudah Digunakan.";
            }
        }
        if($request->companyid == ""){
            //BY APROVE
            // $request['userid'] = session('UIDGlob')->userid;
            // $request['companyid'] = "Pending Approval";
            // $data = [
            //     'type' => 'subscribe',
            //     'request' => json_encode($request->all()),
            //     'url' => url('') . '/aprovalfile?' . http_build_query($request->all()),
            // ];
            // $masterUser = tbluser::find(1);
            // Mail::to($masterUser->email)->send(new SendMail($data));

            //LANGSUNG BAYAR
            if(null == tblcomp::where('email',$request->email)->first()){
                $tblcomp = tblcomp::insertGetId([
                    'statusid' => 1,
                    'companyname' => $request->companyname,
                    'companyaddress' => $request->companyaddress,
                    'email' => $request->email,
                    'hp' => $request->hp,
                    'producttypeArray' => json_encode($request->producttypeArray),
                    'UserInsert' => auth()->user()->userid,
                    'UserUpdate' => auth()->user()->userid,
                    'InsertDT' => Carbon::now(config('app.GMT')),
                    'UpdateDT' => Carbon::now(config('app.GMT')),
                ]);
                tbluser::find(auth()->user()->userid)->update(['companyid' => $tblcomp]);
                $adminController = new adminController;
                $adminController->createSubscribe($request->subscribe,auth()->user()->userid);

                session(['UIDGlob' => tbluser::find(auth()->user()->userid)]);
                session(['track' => 'null']);
                return 'view';
            }

            $msg="Success";
            
        }else{
            $tblcomp = tblcomp::find($request->companyid);
            $tblcomp->update([
                'companyname' => $request->companyname,
                'companyaddress' => $request->companyaddress,
                'email' => $request->email,
                'hp' => $request->hp,
                'producttypeArray' => json_encode($request->producttypeArray),
                'UserUpdate' => session('UIDGlob')->userid,
                'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
            $msg="Success";
        }
        return $msg;
    }
}
