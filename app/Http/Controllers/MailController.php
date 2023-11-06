<?php

namespace App\Http\Controllers;

use App\Models\tblcomp;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function aprovalfile(Request $request){
        if(null == tblcomp::where('email',$request->email)->first()){
            $tblcomp = tblcomp::insertGetId([
                'statusid' => 1,
                'companyname' => $request->companyname,
                'companyaddress' => $request->companyaddress,
                'email' => $request->email,
                'hp' => $request->hp,
                'producttypeArray' => json_encode($request->producttypeArray),
                'UserInsert' => $request->userid,
                'UserUpdate' => $request->userid,
                'InsertDT' => Carbon::now(config('app.GMT')),
                'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
            tbluser::find($request->userid)->update(['companyid' => $tblcomp]);
            $adminController = new adminController;
            $adminController->createSubscribe($request->subscribe,$request->userid);
            return view('success');
        }
        return "<h1>EMAIL ".$request->email." TELAH DIGUNAKAN<h1>";
    }
}
