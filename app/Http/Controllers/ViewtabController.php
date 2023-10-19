<?php

namespace App\Http\Controllers;

use App\Models\tblagenda;
use App\Models\tblcomp;
use App\Models\tblmasterproduct;
use App\Models\tblpaymentmethod;
use App\Models\tblpengumuman;
use App\Models\tblproducttype;
use App\Models\tbltrans;
use App\Models\tbluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Midtrans\CreateSnapTokenService; 

class ViewtabController extends Controller
{
    public function Getnavbar(Request $request){
        return view('layout.'.$request->name)->render();
    }
    public function selectComp(Request $request){
        $data['id'] = $request->id;
        $data['name'] = $request->name;
        return view('getView.selectCompany',compact('data'))->render();
    }
    public function viewaddpesanforum(){
        $companyarray = [];
        if(session('UIDGlob')->companyidArray != null){
            $companyidarray = explode(',',session('UIDGlob')->companyidArray);
            array_pop($companyidarray);
            $tblcompAry = tblcomp::whereIn('companyid',$companyidarray)->get();
            if(session('UIDGlob')->companyid != null){
                $companyarray[session('UIDGlob')->companyid] = tblcomp::find(session('UIDGlob')->companyid)->companyname;
            }
            foreach ($tblcompAry as $c) {
                $companyarray[$c->companyid] = $c->companyname;
            }
        }else{
            $tblcompAry = tblcomp::find(session('UIDGlob')->companyid);
            $companyarray[$tblcompAry->companyid] = $tblcompAry->companyname;
        }
        return view('getView.viewFormpesanforum',compact('companyarray'))->render();
    }
    public function viewpivotmybilling(){
        return view('getView.viewPivotmybilling')->render();
    }
    public function viewaddpengelola(){
        return view('getView.viewFormaddpengelola')->render();
    }
    public function viewaddcustomer(){
        return view('getView.viewFormaddcustomer')->render();
    }
    public function viewhome(){
        return view('getView.viewHome')->render();
    }
    public function viewmasterproduct(){
        return view('getView.viewMasterProduct')->render();
    }
    public function viewproductype(){
        return view('getView.viewProductType')->render();
    }
    public function viewpaymentmethod(){
        return view('getView.viewPaymentMethod')->render();
    }
    public function viewchat(){
        return view('getView.viewChat')->render();
    }
    public function viewpolling(Request $request){
        $tblpengumuman = tblpengumuman::find($request->pengumumanid);
        $arrayPolling = json_decode($tblpengumuman->polling);
        foreach ($arrayPolling as $p) {
            $splitkeyval = explode(";", $p);
            $keypoling[$splitkeyval[0]] = isset($splitkeyval[1])?$splitkeyval[1]:'';
        }
        foreach ($keypoling as $key => $val) {
            $arrayuser = json_decode($val, true); 
            $usercollect = [];
            if(is_array($arrayuser)){
                foreach ($arrayuser as $u) {
                    $usercollect[] = tbluser::select('nama','profileImg')->where('userid',$u)->first();
                }
            }
            $data[$key] = $usercollect;
        }
        return view('getView.viewPolling',compact('data'))->render();
    }
    public function viewkomentarpengumuman(Request $request){
        $tblpengumuman = tblpengumuman::find($request->pengumumanid);
        return view('getView.viewKomentarpengumuman',compact('tblpengumuman'))->render();
    }
    public function viewformbilling(Request $request){
        $dataUser = tbluser::where('userid',$request->val)->first();
        $nama = $dataUser->nama;
        return view('getView.viewFormbilling',compact('nama'))->render();
    }
    public function viewformagenda(Request $request){
        $agenda = tblagenda::find($request->val);
        $produk = tblmasterproduct::select('productName')->find($agenda->productCode)->productName;
        return view('getView.viewformagenda',compact('agenda','produk'))->render();
    }
    public function viewpayment(Request $request){
        $trans = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan','tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
        ->addSelect(DB::raw('(SELECT COUNT(notrans) FROM tbltrans s WHERE AppointmentId = tbltrans.AppointmentId AND userid = tbltrans.userid AND jatuhTempoTagihan <= tbltrans.jatuhTempoTagihan) as angsuran'))
        ->join('tbluser','tbluser.userid','=','tbltrans.userid')
        ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
        ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
        ->where('notrans',$request->val)->first();

        if(isset($trans)){
            $file = '';
            $path = storage_path('app/public/user/'.$trans->userid.'/notrans/'.$trans->notrans.'.*');
            $files = glob($path);
            foreach($files as $f){
                $file = basename($f);
                $file = asset("storage/app/public/user/".$trans->userid."/notrans/".$file);
            }
            $paymentMethod = tblpaymentmethod::select('paymentid','paymentName','RekTujuan','AtasNama')->where('statusid','!=',4)->whereIn('companyid',[$trans->companyid,1])->get();
            $us = tbltrans::find($trans->notrans);
            if($us->snap_token != null){
                $snapToken = $us->snap_token;
            }else{
                $midtrans = new CreateSnapTokenService($trans);
                $snapToken = $midtrans->getSnapToken();
                $us->update(['snap_token' => $snapToken]);
            }   
            return view('getView.viewPayment',compact('file','trans','paymentMethod','snapToken'))->render();
        }else{
            return 0;
        }
    }
    public function viewlonceng(){
        $controller = new Controller;
        $cid = $controller->inCidNotSelf();
        $notif['myAgendda'] = DB::select("SELECT text FROM tblagenda WHERE userid = ".session('UIDGlob')->userid." AND isBilling = 0 AND CONVERT(VARCHAR, GETDATE(), 12) = CONVERT(VARCHAR, EndDate, 12)");
        $notif['chat'] = DB::select("SELECT count(d.userid) AS total,d.userid,max(u.nama) AS nama, max(h.chatid) AS chatid
                                    FROM tblchat h 
                                    JOIN tblchatd d ON h.chatid=d.chatid
                                    JOIN tbluser u ON u.userid=d.userid
                                    WHERE PATINDEX('%[".session('UIDGlob')->userid."]%', userArray) > 0 
                                    AND d.userid != ".session('UIDGlob')->userid." 
                                    AND h.companyid IN (".$cid.") 
                                    AND d.statusid NOT IN (9,4) 
                                    GROUP BY d.userid");
        $notif['pengumuman'] = DB::select("SELECT judul,pengumumanid,isPengumumanCompany FROM tblpengumuman WHERE UserInsert != ".session('UIDGlob')->userid." 
                                            AND UserInsert = 1
                                            AND 2 NOT IN (SELECT value FROM STRING_SPLIT(usersRead, ','))                                    
                                            AND statusid NOT IN (4)
                                            UNION
                                            SELECT judul,pengumumanid,isPengumumanCompany FROM tblpengumuman WHERE UserInsert != ".session('UIDGlob')->userid." 
                                            AND companyid IN (".$cid.") AND companyid <> 1
                                            AND ".session('UIDGlob')->userid." NOT IN (SELECT value FROM STRING_SPLIT(usersRead, ','))                                    
                                            AND statusid NOT IN (4)");
        
        $notif['invoice'] = DB::select("SELECT t.*, a.Text FROM tbltrans t
                                        JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                                        WHERE t.statusid NOT IN (7, 8, 9, 4) 
                                        AND t.companyid IN (".$cid.") 
                                        AND t.userid = ".session('UIDGlob')->userid." 
                                        AND DATEADD(DAY, -7, t.jatuhTempoTagihan) < '".now()->toDateTimeString()."'");
        
        $notif['invoiceReject'] = DB::select("SELECT t.*, a.Text FROM tbltrans t
                                        JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                                        WHERE t.statusid NOT IN (8, 9, 4) 
                                        AND t.companyid IN (".$cid.") 
                                        AND t.userid = ".session('UIDGlob')->userid." 
                                        AND t.isreject = 1");

        $mycompanyid =  isset(session('UIDGlob')->companyid)? session('UIDGlob')->companyid : 0 . " ";
        $notif['invoiceWaiting'] = DB::select("SELECT t.*, a.Text FROM tbltrans t
                                            JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                                            WHERE t.statusid = 6 AND t.companyid = " . $mycompanyid);
        
        $notif['count'] = count($notif['myAgendda'])+count($notif['chat'])+count($notif['pengumuman'])+count($notif['invoice'])+count($notif['invoiceReject'])+count($notif['invoiceWaiting']);
        return view('getView.viewLonceng',compact('notif'))->render();
    }
    public function viewHeaderchat(){
        if(session('UIDGlob')->companyid == null){
            $arr = explode(',', session('UIDGlob')->companyidArray);
            array_pop($arr);
            $cid = "'" . implode("','", $arr) . "'";
        }else{
            $cid = "'".session('UIDGlob')->companyid."'";
        }
        $tblchat = DB::select("SELECT c.*, u.nama, u.companyid AS pengelola, u.profileImg, d1.description AS latestChat, d2.description AS firstChat, d1.InsertDT
                            FROM tblchat c
                            LEFT JOIN (
                                SELECT chatid, description, InsertDT
                                FROM tblchatd
                                WHERE id IN (
                                    SELECT MAX(id)
                                    FROM tblchatd
                                    GROUP BY chatid
                                )
                                AND statusid <> 4
                            ) d1 ON c.chatid = d1.chatid
                            LEFT JOIN (
                                SELECT chatid, description
                                FROM tblchatd
                                WHERE id IN (
                                    SELECT MIN(id)
                                    FROM tblchatd
                                    GROUP BY chatid
                                )
                                AND statusid <> 4
                            ) d2 ON c.chatid = d2.chatid
                            JOIN tbluser u ON u.userid IN (
                                                            SELECT CAST(REPLACE(REPLACE(value, '[', ''), ']', '') AS INT)
                                                            FROM STRING_SPLIT(c.userarray, ',')
                                                        )
                            WHERE c.statusid <> 4 
                            AND (CASE 
									WHEN CHARINDEX(',', REPLACE(REPLACE(userarray, '[', ''), ']', '')) > 0 THEN LEFT(REPLACE(REPLACE(userarray, '[', ''), ']', ''), CHARINDEX(',', REPLACE(REPLACE(userarray, '[', ''), ']', '')) - 1)
								END = ".session('UIDGlob')->userid." 
							OR CASE 
									WHEN CHARINDEX(',', REPLACE(REPLACE(userarray, '[', ''), ']', '')) > 0 THEN RIGHT(REPLACE(REPLACE(userarray, '[', ''), ']', ''), LEN(REPLACE(REPLACE(userarray, '[', ''), ']', '')) - CHARINDEX(',', REPLACE(REPLACE(userarray, '[', ''), ']', '')))
								END = ".session('UIDGlob')->userid." )
                            AND u.userid != ".session('UIDGlob')->userid."
                            AND c.companyid IN (".$cid.")");

        return view('getView.viewHeaderchat',compact('tblchat'))->render();
    }
    public function pusher(){
        return view('getView.pusher')->render();
    }
}
