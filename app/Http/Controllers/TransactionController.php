<?php

namespace App\Http\Controllers;

use App\Models\tblagenda;
use App\Models\tblcomp;
use App\Models\tblpaymentmethod;
use App\Models\tblpaymenttrans;
use App\Models\tbltrans;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\tbluser;
use Symfony\Component\Translation\Extractor\Visitor\TransMethodVisitor;

class TransactionController extends Controller
{
    public function nextAppointment($startDate,$recurenceRule,$recurenceException,$lastDate){
        $startDate = Carbon::parse($startDate);
        $recurenceRule = explode(";",$recurenceRule);
        $recurenceException = explode(",",$recurenceException);
        foreach($recurenceRule as $val){
            $recurs = explode("=",$val);
            $Recurr[$recurs[0]] = $recurs[1];
        }
        // $log = new Controller;
        $INTERVAL = 1;
        if(isset($Recurr['INTERVAL'])){
            $INTERVAL = $Recurr['INTERVAL'];
        }
        Loop:
        $finishDate = $startDate->copy()->addYear(10);
        if($Recurr['FREQ'] == "HOURLY"){
            if(isset($Recurr['COUNT'])){
                $finishDate = $startDate->copy()->addHour($Recurr['COUNT'] - 1);
            }
            $lD = Carbon::parse($lastDate)->addHour($INTERVAL);
            $nextDate = $startDate->copy()->addHour($INTERVAL);
            foreach($recurenceException as $Recure){
                if($nextDate == Carbon::parse($Recure)){
                    $nextDate = $nextDate->addHour($INTERVAL);
                }
            }
        }else if($Recurr['FREQ'] == "DAILY"){
            if(isset($Recurr['COUNT'])){
                $finishDate = $startDate->copy()->addDay($Recurr['COUNT'] - 1);
            }
            $lD = Carbon::parse($lastDate)->addDay($INTERVAL);
            $nextDate = $startDate->copy()->addDay($INTERVAL);
            foreach($recurenceException as $Recure){
                if($nextDate == Carbon::parse($Recure)){
                    $nextDate = $nextDate->addDay($INTERVAL);
                }
            }
        }else if($Recurr['FREQ'] == "WEEKLY"){
            if(isset($Recurr['COUNT'])){
                $finishDate = $startDate->copy()->addWeek($Recurr['COUNT'] - 1);
            }
            $lD = Carbon::parse($lastDate)->addWeek();
            if (isset($Recurr['BYDAY'])) {
                $days = explode(",", $Recurr['BYDAY']);
                $nextDate = $startDate->copy();
                while (true) {
                    $nextDate->addDay($INTERVAL);
                    foreach($recurenceException as $Recure){
                        if($nextDate->format('ymd') == Carbon::parse($Recure)->addDay($INTERVAL)->format('ymd')){
                            $nextDate = $nextDate->addDay($INTERVAL);
                        }
                    }
                    if (in_array(strtoupper(substr($nextDate->englishDayOfWeek, 0, 2)), $days)) {
                        break;
                    }
                }
            }else{
                $nextDate = $startDate->copy()->addWeek($INTERVAL);
                foreach($recurenceException as $Recure){
                    if($nextDate == Carbon::parse($Recure)){
                        $nextDate = $nextDate->addWeek($INTERVAL);
                    }
                }
            }
        }else if($Recurr['FREQ'] == "MONTHLY"){
            if(isset($Recurr['COUNT'])){
                $finishDate = $startDate->copy()->addMonth($Recurr['COUNT'] - 1);
            }
            $lD = Carbon::parse($lastDate)->addMonth($INTERVAL);
            $nextDate = $startDate->copy()->addMonth($INTERVAL);
            foreach($recurenceException as $Recure){
                if($nextDate == Carbon::parse($Recure)){
                    $nextDate = $nextDate->addMonth($INTERVAL);
                }
            }
        }else if($Recurr['FREQ'] == "YEARLY"){
            if(isset($Recurr['COUNT'])){
                $finishDate = $startDate->copy()->addYear($Recurr['COUNT'] - 1);
            }
            $lD = Carbon::parse($lastDate)->addYear($INTERVAL);
            $nextDate = $startDate->copy()->addYear($INTERVAL);
            foreach($recurenceException as $Recure){
                if($nextDate == Carbon::parse($Recure)){
                    $nextDate = $nextDate->addYear($INTERVAL);
                }
            }
        }
        if(isset($Recurr['UNTIL'])){
            $finishDate = Carbon::parse($Recurr['UNTIL']);
        }

        if($nextDate->lessThan($lD)){
            $startDate = $nextDate;
            goto Loop;
        }
        if($finishDate->greaterThan($nextDate)){
            return $nextDate;
        }else{
            return false;
        }
    }
    public function nextTransaction($AppointmentId,$userid,$lastDate,$companyid){ 
        // note: jika lastdate tidak ada maka tidak ada recuren
        $tblcomp = tblcomp::find($companyid);
        $notransHeader = $companyid.strtoupper(substr($tblcomp->companyname, 0, 2)).Carbon::now(config('app.GMT'))->format('ymd');
        $lastTrans = DB::select("SELECT ISNULL(MAX(CAST(SUBSTRING(notrans, LEN('$notransHeader') + 1, LEN(notrans)) AS INT)) + 1, 1) AS maxNotrans
                                    FROM tbltrans
                                    WHERE notrans LIKE '".$notransHeader."%'");

        $notrans = $notransHeader.sprintf("%05d", $lastTrans[0]->maxNotrans);
        while ($this->cekstatusMID($notrans)->status_code != 404) {
            $notrans = intval(substr($notrans, strlen($notransHeader))); // Mengambil angka dari nomor transaksi
            $notrans++; // Increment nomor transaksi jika sudah dipakai di MIDTRANS
            $notrans = $notransHeader.sprintf("%05d", $notrans); // Menggabungkan kembali nomor transaksi yang telah di-increment
        }
        $tblagenda = tblagenda::find($AppointmentId);
        if($lastDate == null){
            $nextDate = Carbon::parse(tblagenda::find($AppointmentId)->StartDate);
        }else{
            $nextDate = $this->nextAppointment($tblagenda->StartDate,$tblagenda->RecurrenceRule,$tblagenda->RecurrenceException,$lastDate);
        }
        if($nextDate != false){
            $cekIssetTrans = tbltrans::where('jatuhTempoTagihan',$nextDate)
                                        ->where('companyid',$companyid)
                                        ->where('userid',$userid)
                                        ->where('AppointmentId',$AppointmentId)
                                        ->where('statusid','<>',4)
                                        ->first();
            $log = new Controller;
            $log->savelog(json_encode($cekIssetTrans));
            if(!isset($cekIssetTrans)){ //Jika sudah ada jangan buat transaksi tagihan
                tbltrans::create([
                    'notrans' => $notrans,
                    'AppointmentId' => $AppointmentId,
                    'companyid' => $companyid,
                    'userid' => $userid,
                    'statusid' => 5,
                    'SisaPok' => $tblagenda->Pokok,
                    'Pokok' => $tblagenda->Pokok,
                    'Bunga' => ($tblagenda->Pokok * $tblagenda->BungaPercent / 100),
                    'LateFee' => ($tblagenda->Pokok * $tblagenda->lateFeePercent / 100),
                    'JHT' => 0,
                    'SPokok' => $tblagenda->Pokok,
                    'SBunga' => 0,
                    'SLateFee' => 0,
                    'transdate' => now(config('app.GMT')),
                    'jatuhTempoTagihan' => $nextDate,
                    'UserInsert' => session('UIDGlob')->userid,
                    'InsertDT' => now(config('app.GMT')),
                    'UserUpdate' => session('UIDGlob')->userid,
                    'UpdateDT' => now(config('app.GMT')),
                ]);
            }
        }
        return true;
    }
    public function getbill(){
        $data = DB::select("SELECT t.statusid, t.notrans, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, p.productName
                            FROM tbltrans t
                            JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                            JOIN tblmasterproduct p ON p.productCode=a.productCode
                            WHERE t.statusid IN (5,6,11) AND t.userid = '".session('UIDGlob')->userid."'
                            ORDER BY text, t.jatuhTempoTagihan ASC");
        return $data;
    }
    public function gettransaction(Request $request){
        if($request->type != 'c'){
            $arr = explode(',', session('UIDGlob')->companyidArray);
            array_pop($arr);
            $cid = "'" . implode("','", $arr) . "'";
            
            return DB::select("SELECT u.nama, t.notrans, t.transdate, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName
                FROM tbltrans t
                JOIN tblstatus s ON t.statusid=s.statusid
                JOIN tbluser u ON u.userid=t.userid
                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                JOIN tblmasterproduct p ON p.productCode=a.productCode
                JOIN tblpaymentmethod ON t.paymentid=tblpaymentmethod.paymentid
                WHERE t.statusid != 4 AND t.companyid IN (".$cid.") AND t.userid = ".session('UIDGlob')->userid);
        }else{
            return DB::select("SELECT u.nama, t.notrans, t.transdate, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName
                FROM tbltrans t
                JOIN tblstatus s ON t.statusid=s.statusid
                JOIN tbluser u ON u.userid=t.userid
                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                JOIN tblmasterproduct p ON p.productCode=a.productCode
                join tblpaymentmethod on t.paymentid=tblpaymentmethod.paymentid
                WHERE t.statusid != 4 AND t.companyid = ".session('UIDGlob')->companyid);
        }
    }
    public function getjatuhtempo(){
        return DB::select("SELECT jatuhTempoTagihan
                            FROM tbltrans
                            where userid = ".session('UIDGlob')->userid."
                            group by jatuhTempoTagihan");
    }
    public function confirmPembayaran(Request $request){
        // try {
            DB::beginTransaction();
            $chatcontroller = new ChatController;
            $tbltrans = tbltrans::find($request->notrans);
            $status = 1;
            if($tbltrans->statusid != 13){
                if($tbltrans->statusid == 5 || $tbltrans->statusid == 11){
                    if(session('UIDGlob')->companyid != $tbltrans->companyid){
                        //MELAKUKAN PEMBAYARAN
                        if ($request->hasFile('files')) {
                            if($request->paymentid == null){
                                $status = 4;
                            }
                            $path = storage_path('app/public/user/'.session('UIDGlob')->userid.'/notrans/'.$request->notrans.'.*');
                            $files = glob($path);
                            foreach($files as $f){
                                File::delete($f);
                            }
                            $file = $request->file('files');
                            $exten = $file->getClientOriginalExtension();
                            $file->storeAs('public/user/'.session('UIDGlob')->userid.'/notrans', $request->notrans.'.'.$exten);
                            $tbltrans->update(['statusid' => 6, 'isreject' => 0, 'paymentid' => $request->paymentid]);
                            $chatcontroller->GlobalPush("notif",$tbltrans->UserInsert);
                        }else{
                            $status = 0;
                        }
                    }else{
                        $status = 2;
                    }
                }else if($tbltrans->statusid == 6){
                    if(session('UIDGlob')->companyid == $tbltrans->companyid){
                        if($request->reject == 1){
                            //TOLAK PEMBAYARAN
                            $tbltrans->update([
                                'isreject' => 1, 
                                'statusid' => 5, 
                                'UserUpdate' => session('UIDGlob')->userid,
                                'UpdateDT' => Carbon::now(config('app.GMT')),
                            ]);
                            $chatcontroller->GlobalPush("notif",$tbltrans->userid);
                            $chatcontroller->GlobalPush("renderMyBilling",$tbltrans->userid);
                        }else{
                            //KONFIRMASI PEMBAYARAN
                            $tbltrans->update(['statusid' => 7]);
                            $total = $tbltrans->SPokok + $tbltrans->SBunga + $tbltrans->SLateFee;
                            tblpaymenttrans::create([
                                'notrans' => $tbltrans->notrans,
                                'paymentid' => $tbltrans->paymentid,
                                'statusid' => $tbltrans->statusid,
                                'tglBayar' => $tbltrans->transdate,
                                'tglVerifikasi' => Carbon::now(config('app.GMT')) ,
                                'payment_type' => tblpaymentmethod::find($tbltrans->paymentid)->paymentName,
                                'total' => $total,
                                'totalPay' => $total,
                                'UserInsert' => session('UIDGlob')->userid,
                                'InsertDT' => Carbon::now(config('app.GMT')),
                                'UserUpdate' => session('UIDGlob')->userid,
                                'UpdateDT' => Carbon::now(config('app.GMT')),
                            ]);
                            $this->nextTransaction($tbltrans->AppointmentId,$tbltrans->userid,$tbltrans->jatuhTempoTagihan,session('UIDGlob')->companyid);
                            $chatcontroller->GlobalPush("renderMyBilling",$tbltrans->userid);
                            $transMail = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan','tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
                                                    ->addSelect(DB::raw('(SELECT COUNT(notrans) + 1 FROM tbltrans s WHERE AppointmentId = tbltrans.AppointmentId AND userid = tbltrans.userid AND jatuhTempoTagihan <= tbltrans.jatuhTempoTagihan) as angsuran'))
                                                    ->addSelect(DB::raw('CASE WHEN tbltrans.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname'))
                                                    ->join('tbluser','tbluser.userid','=','tbltrans.userid')
                                                    ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
                                                    ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
                                                    ->join('tblpaymentmethod','tblpaymentmethod.paymentid','=','tbltrans.paymentid')
                                                    ->where('notrans',$tbltrans->notrans)->first();
                                                    // JOIN tblpaymentmethod ON t.paymentid=tblpaymentmethod.paymentid CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname
                            $arrayMail = [
                                'email' => DB::select('SELECT TOP 1 email FROM tbluser WHERE userid = '.$tbltrans->userid)[0]->email,
                                'trans' => $transMail,
                            ];
                            $this->sendMailPayment($arrayMail);
                            $arrayMail2 = [
                                'email' => DB::select('SELECT TOP 1 email FROM tbluser WHERE companyid = '.$tbltrans->companyid)[0]->email,
                                'trans' => $transMail,
                            ];
                            // $this->sendMailPayment($arrayMail2);
                        }
                    }else{
                        $status = 3;
                    }
                }
            }else{
                $status = 5;
            }
            DB::commit();
            $msg = "UNKNOWN STATUS!";
            if($status == 0){
                $msg = "Tolong Masukan Bukti Pembayaran Anda";
            }else if($status == 2){
                $msg = "Anda Tidak Bisa Membayar Tagihan ini";
            }else if($status == 3){
                $msg = "Anda Tidak Bisa Mengkonfirmasi Tagihan ini";
            }else if($status == 4){
                $msg = "Tipe Pembayaran Tidak Ditemukan";
            }else if($status == 5){
                $msg = "Tagihan Tidak Berlaku";
            }
            if($status == 1){
                return "Success";
            }else{
                return $msg;
            }
        // } catch (\Exception $e) {
            DB::rollBack();
            return 'Please Contact Team Suport';
        // }
    }
    public function confirmPembayaranMID(Request $request){
        $MID = $this->cekstatusMID($request->notrans);
        $transG = null;
        $snapToken = null;
        try {
            DB::beginTransaction();
            $tbltrans = tbltrans::find($request->notrans);
            if($tbltrans->statusid != 13){
                $cid = explode(',', session('UIDGlob')->companyidArray);
                array_pop($cid);
                if (in_array($tbltrans->companyid, $cid) && $MID->status_code == '200' && $MID->transaction_status == 'settlement') {
                    //KONFIRMASI PEMBAYARAN
                    $tbltrans->update(['statusid' => 7,'paymentid' => 2]);
                    tblpaymenttrans::create([
                        'notrans' => $tbltrans->notrans,
                        'paymentid' => 2, //midtrans
                        'statusid' => $tbltrans->statusid,
                        'tglBayar' => $tbltrans->transdate,
                        'tglVerifikasi' => Carbon::now(config('app.GMT')) ,
                        'payment_type' => $MID->payment_type,
                        'total' => $tbltrans->SPokok + $tbltrans->SBunga + $tbltrans->SLateFee,
                        'totalPay' => $tbltrans->SPokok + $tbltrans->SBunga + $tbltrans->SLateFee,
                        'UserInsert' => session('UIDGlob')->userid,
                        'InsertDT' => Carbon::now(config('app.GMT')),
                        'UserUpdate' => session('UIDGlob')->userid,
                        'UpdateDT' => Carbon::now(config('app.GMT')),
                    ]);
                    $this->nextTransaction($tbltrans->AppointmentId,$tbltrans->userid,$tbltrans->jatuhTempoTagihan,$tbltrans->companyid);
                    
                    $transMail = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan','tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
                                                    ->addSelect(DB::raw('(SELECT COUNT(notrans) + 1 FROM tbltrans s WHERE AppointmentId = tbltrans.AppointmentId AND userid = tbltrans.userid AND jatuhTempoTagihan <= tbltrans.jatuhTempoTagihan) as angsuran'))
                                                    ->join('tbluser','tbluser.userid','=','tbltrans.userid')
                                                    ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
                                                    ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
                                                    ->where('notrans',$tbltrans->notrans)->first();
                    $arrayMail = [
                        'email' => DB::select('SELECT TOP 1 email FROM tbluser WHERE userid = '.$tbltrans->userid)[0]->email,
                        'trans' => $transMail,
                    ];
                    $this->sendMailPayment($arrayMail);
                    $arrayMail2 = [
                        'email' => DB::select('SELECT TOP 1 email FROM tbluser WHERE companyid = '.$tbltrans->companyid)[0]->email,
                        'trans' => $transMail,
                    ];
                    $this->sendMailPayment($arrayMail2);
                }
                if($MID->status_code == '201'){
                    $statusTrans = 11 ; // Pending Midtrans
                }else{
                    $statusTrans = $tbltrans->statusid;
                }
                if($MID->status_code == 407){// Expire midtrans
                    // $trans = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan' ,'tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
                    // ->join('tbluser','tbluser.userid','=','tbltrans.userid')
                    // ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
                    // ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
                    // ->where('notrans',$tbltrans->notrans)->first();
                    // $trans->snap_token = null;
                    // $midtrans = new CreateSnapTokenService($trans);
                    // $snapToken = $midtrans->getSnapToken();
                    // $tbltrans->update(['snap_token' => $snapToken]);
                    // $MID = $this->cekstatusMID($request->notrans);
                    // disini buat trans baru
                    $transOld = tbltrans::where('notrans',$tbltrans->notrans)->first();
                    $tblcomp = tblcomp::find($transOld->companyid);
                    $notransHeader = $transOld->companyid.strtoupper(substr($tblcomp->companyname, 0, 2)).Carbon::now(config('app.GMT'))->format('ymd');
                    $lastTrans = DB::select("SELECT ISNULL(MAX(CAST(SUBSTRING(notrans, LEN('$notransHeader') + 1, LEN(notrans)) AS INT)) + 1, 1) AS maxNotrans
                                                FROM tbltrans
                                                WHERE notrans LIKE '".$notransHeader."%'");

                    $notrans = $notransHeader.sprintf("%05d", $lastTrans[0]->maxNotrans);
                    while ($this->cekstatusMID($notrans)->status_code != 404) {
                        $notrans = intval(substr($notrans, strlen($notransHeader))); // Mengambil angka dari nomor transaksi
                        $notrans++; // Increment nomor transaksi jika sudah dipakai di MIDTRANS
                        $notrans = $notransHeader.sprintf("%05d", $notrans); // Menggabungkan kembali nomor transaksi yang telah di-increment
                    }
                    $transNew = tbltrans::create([
                        'notrans' => $notrans,
                        'notransExpire' => $transOld->notrans,
                        'AppointmentId' => $transOld->AppointmentId,
                        'companyid' => $transOld->companyid,
                        'userid' => $transOld->userid,
                        'statusid' => 5,
                        'SisaPok' => $transOld->SisaPok,
                        'Pokok' => $transOld->Pokok,
                        'Bunga' => $transOld->Bunga,
                        'LateFee' => $transOld->LateFee,
                        'JHT' => $transOld->JHT,
                        'SPokok' => $transOld->SPokok,
                        'SBunga' => $transOld->SBunga,
                        'SLateFee' => $transOld->SLateFee,
                        'transdate' => $transOld->transdate,
                        'snap_token' => null,
                        'jatuhTempoTagihan' => $transOld->jatuhTempoTagihan,
                        'UserInsert' => session('UIDGlob')->userid,
                        'InsertDT' => now(config('app.GMT')),
                        'UserUpdate' => session('UIDGlob')->userid,
                        'UpdateDT' => now(config('app.GMT')),
                    ]);
                    $trans = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan' ,'tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
                    ->join('tbluser','tbluser.userid','=','tbltrans.userid')
                    ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
                    ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
                    ->where('notrans',$notrans)->first();

                    $transOld->update(['statusid' => 4]);
                    $transG = $notrans;
                    $midtrans = new CreateSnapTokenService($trans);
                    $snapToken = $midtrans->getSnapToken();
                    $transNew->update(['snap_token' => $snapToken]);
                    $MID = $this->cekstatusMID($request->notrans);
                }
                $tbltrans->update([
                    'statusid' => $statusTrans, 
                    'MIDstatus' => $MID->status_code, 
                    'MIDstatusmsg' => isset($MID->transaction_status)?$MID->transaction_status:'', 
                    'MIDUpdateUser' => session('UIDGlob')->userid,
                    'MIDpaymenttype' => isset($MID->payment_type)?$MID->payment_type:'',
                    'MIDall' => json_encode($MID),
                ]);
                DB::commit();
                return [
                    'transG' => $transG,
                    'snapToken' => $snapToken,
                    'status' => $MID->status_code,
                    'msg' => isset($MID->transaction_status)?$MID->transaction_status:'Invoice Expire - Generate Ulang Invoice ', 
                ];
            }
            return [
                'transG' => null,
                'snapToken' => null,
                'status' => null,
                'msg' => "Tagihan Tidak Berlaku",
            ];
            
        }catch (\Exception $e) {
            DB::rollBack();
            $tbltrans->update(['statusid' => 5,'paymentid' => 2]); //12
            // dd($e); // hidupkan untuk debug
            return [
                'status' => 404,
                'msg' => "Transaction Rollback",
            ];
        }
    }
    public function cekstatusMID($notrans){
        $url = config('app.URLmidv2').$notrans.'/status';
        $headers = array(
            'Accept: application/json',
            'Authorization: Basic U0ItTWlkLXNlcnZlci03STQ3NGV6QUE4QXZiejlzT0VHTW81bnc6'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            return false;
        } else {
            return json_decode($response);
        }
    }
    public function cancleMID($notrans){
        $endpoint = config('app.URLmidv2').$notrans.'/cancel';

        $headers = array(
            'Accept: application/json',
            'Authorization: Basic U0ItTWlkLXNlcnZlci03STQ3NGV6QUE4QXZiejlzT0VHTW81bnc6'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = json_decode(curl_exec($curl));
        if($response->status_code == 412){
            return false;
        }
        tbltrans::find($notrans)->update(['snap_token' => null]);
        curl_close($curl);
        if ($response === false) {
            return false;
        } else {
            return $response;
        }
    }
    public function voidtrans(Request $request){
        $tbltrans = tbltrans::find($request->notrans);
        if($tbltrans->companyid != session('UIDGlob')->companyid){
            return "tidak bisa akses!";
        }
        $tbltrans->update([
            'statusid' => 13,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        $this->cancleMID($request->notrans);
        $this->nextTransaction($tbltrans->AppointmentId,$tbltrans->userid,$tbltrans->jatuhTempoTagihan,session('UIDGlob')->companyid);
        return true;
    }
    private function sendMailPayment($array){
        $data = [
            'type' => 'mailpayment',
            'trans' => $array['trans'],
        ];
        Mail::to($array['email'])->send(new SendMail($data));
    }

    public function eod(){
        DB::update("UPDATE tbltrans SET 
        jht = IIF(DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP) > 0, DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP),0), 
        SLateFee = LateFee * IIF(DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP) > 0, DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP),0),
        SPokok = Pokok");

        $tblagenda = collect(DB::select("SELECT a.AppointmentId, t.companyid, t.userid, t.notrans,t.jatuhTempoTagihan,a.StartDate,a.RecurrenceRule,a.RecurrenceException FROM tblagenda a
                                        JOIN (SELECT AppointmentId, userid, companyid, MAX(notrans) AS notrans,MAX(jatuhTempoTagihan) AS jatuhTempoTagihan FROM tbltrans
                                                WHERE statusid <> 4
                                                GROUP BY companyid, userid, AppointmentId) AS t ON a.AppointmentId=t.AppointmentId
                                        WHERE productCode IS NOT NULL and isBilling = 1
                                        AND a.statusid <> 4"));
        foreach ($tblagenda as $agenda) {
            $nextDate = $this->nextAppointment($agenda->StartDate,$agenda->RecurrenceRule,$agenda->RecurrenceException,$agenda->jatuhTempoTagihan);
            // $log = new Controller;
            if( Carbon::parse($nextDate)->format('ymd') == Carbon::now(config('GMT'))->format('ymd') ){
                // $log->savelog('create dari jatuhtempo ' . $agenda->jatuhTempoTagihan );
                $this->nextTransaction($agenda->AppointmentId,$agenda->userid,$agenda->jatuhTempoTagihan,$agenda->companyid);
            }
        }
        return true;
    }
}