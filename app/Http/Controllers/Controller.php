<?php

namespace App\Http\Controllers;

use App\Models\tblchatd;
use App\Models\tblcomp;
use App\Models\tblpengumuman;
use App\Models\tblproducttype;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Pusher\Pusher;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        $tblproducttype = tblproducttype::where('statusid','!=',4)->where('companyid',1)->get();
        $tblcomp = tblcomp::where('companyid',session('UIDGlob')->companyid)->first();
        $tblcomp = [
            'companyid' => isset($tblcomp->companyid)? $tblcomp->companyid : '',
            'companyname' => isset($tblcomp->companyname)? $tblcomp->companyname : '',
            'productTypeName' => isset($tblcomp->productTypeName)? $tblcomp->productTypeName : '',
            'email' => isset($tblcomp->email)? $tblcomp->email : '',
            'hp' => isset($tblcomp->hp)? $tblcomp->hp : '',
            'companyaddress' => isset($tblcomp->companyaddress)? $tblcomp->companyaddress : '',
            'producttypeArray' => isset($tblcomp->producttypeArray)? $tblcomp->producttypeArray : '',
        ];
        
        $cid = $this->inCidSelf();

        $dateExpression = Carbon::now(config("app.GMT"))->subMonth(1)->format('Y-m-d H:i:s');
        $query = "SELECT p.*, c.companyname, u.userid, u.nama, u.profileImg, CASE WHEN u.companyid IS NULL THEN 0 ELSE 1 END AS ispengelola 
                FROM tblpengumuman p
                JOIN tbluser u ON u.userid = p.UserInsert
                JOIN tblcomp c ON c.companyid = p.companyid
                WHERE p.statusid <> 4 
                    AND p.UserInsert = 1
                    AND p.InsertDT > '{$dateExpression}'
                UNION
                SELECT p.*, c.companyname, u.userid, u.nama, u.profileImg, CASE WHEN u.companyid IS NULL THEN 0 ELSE 1 END AS ispengelola 
                FROM tblpengumuman p
                JOIN tbluser u ON u.userid = p.UserInsert
                JOIN tblcomp c ON c.companyid = p.companyid
                WHERE p.statusid <> 4 
                    AND p.companyid IN ({$cid}) AND p.companyid <> 1
                    AND p.InsertDT > '{$dateExpression}'
                ORDER BY InsertDT DESC";
        $tblpengumuman = DB::select($query);
        
        // $countchat = DB::select("SELECT * FROM tblchat WHERE PATINDEX('%[".session('UIDGlob')->userid."]%', userArray) > 0");
        return view('layout/main',compact('tblproducttype','cid','tblcomp','tblpengumuman'));
    }
    public function inCidSelf(){
        $arr = explode(',', session('UIDGlob')->companyidArray);
        array_pop($arr);
        if(session('UIDGlob')->companyid == null){
            return "'" . implode("','", $arr) . "'";
        }else{
            return "'" . implode("','", $arr) . "'".",'".session('UIDGlob')->companyid."'";
        }
    }
    public function inCidNotSelf(){
        if(session('UIDGlob')->companyid == null){
            $arr = explode(',', session('UIDGlob')->companyidArray);
            array_pop($arr);
            return "'" . implode("','", $arr) . "'";
        }else{
            return "'".session('UIDGlob')->companyid."'";
        }
    }

    public function login(){
        $eod = new TransactionController;
        $eod->eod();
        return view('displayLogin');
    }
    
    public function auuten(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $tbluser = tbluser::where('email',$credentials['email'])->first();
        if(isset($tbluser->statusid)){
            if($tbluser->statusid == 4){
                goto Out;
            }
        }
        if (Auth::attempt($credentials)) {
            session_start();
            $request->session()->regenerate();
            session(['UIDGlob' => auth()->user()]);
            return redirect()->intended('/');
        }
        Out:
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        request()->session()->flush();
        return redirect('/login');
    }

    function savelog($string){
        $file_path = storage_path('SaveLog.xls');
        if (!file_exists($file_path)) {
            $file = fopen($file_path, "w");
            fclose($file);
        }
        $file = fopen($file_path, "a");
        fwrite($file ,$string. "\n");
        fclose($file);
    }

    public function setupPUSHER(){
        $options = array(
            'cluster' => config('app.PUSHER_APP_CLUSTER'),
            'useTLS' => true
        );
 
        $pusher = new Pusher(
            config('app.PUSHER_APP_KEY'),
            config('app.PUSHER_APP_SECRET'),
            config('app.PUSHER_APP_ID'),
            $options
        );
        return $pusher;
    }

    public function PAT($string){
        $PAT = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $PAT .= '['.$string[$i].']';
        }
        return $PAT . '[,]';
    }
}
