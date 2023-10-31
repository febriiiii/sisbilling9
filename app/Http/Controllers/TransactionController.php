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
use App\Models\tblbilling;
use App\Models\tblsyspara;
use App\Models\tbluser;
use DateInterval;
use GuzzleHttp\Client;
use Symfony\Component\Translation\Extractor\Visitor\TransMethodVisitor;

class TransactionController extends Controller
{
    public function nextAppointment($startDate,$recurenceRule,$recurenceException,$lastDate,$skip){
        $startDate = Carbon::parse($startDate);
        $tempStartDate = $startDate;
        $recurenceRule = explode(";",$recurenceRule);
        $recurenceException = explode(",",$recurenceException);
        foreach($recurenceRule as $val){
            $recurs = explode("=",$val);
            $Recurr[$recurs[0]] = $recurs[1];
        }
        $log = new Controller;
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
                    if (in_array(strtoupper(substr($nextDate->englishDayOfWeek, 0, 2)), $days)){
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
                $log->savelog("finishDate1".$finishDate);
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
        
        // $log->savelog("next".$nextDate);
        if($nextDate->lessThan($lD)){
            $startDate = $nextDate;
            goto Loop;
        }
        if($finishDate->greaterThan($nextDate) || $skip){
            if($Recurr['FREQ'] == "MONTHLY"){
                if($tempStartDate->isLastOfMonth()){
                    if($tempStartDate->format('d') == '31'){
                        $nextDate->subMonth()->endOfMonth()->startOfDay();
                    }else{
                        $nextDate->endOfMonth()->startOfDay();
                    }
                }
            }
            return $nextDate;
        }else{
            return false;
        }
    }
    public function transDate($recurenceRule,$nextDate){
        $recurenceRule = explode(";",$recurenceRule);
        foreach($recurenceRule as $val){
            $recurs = explode("=",$val);
            $Recurr[$recurs[0]] = $recurs[1];
        }
        switch ($Recurr['FREQ']) {
            case 'HOURLY':
                return $nextDate->copy()->sub(new DateInterval('PT1H')); // Mengurangkan 1 jam
                break;
            case 'DAILY':
                return $nextDate->copy()->sub(new DateInterval('P1D')); // Mengurangkan 1 hari
                break;
            case 'WEEKLY':
                return $nextDate->copy()->sub(new DateInterval('P7D')); // Mengurangkan 1 minggu
                break;
            case 'MONTHLY':
                    if($nextDate->copy()->isLastOfMonth()){
                        if($nextDate->copy()->format('d') == '31'){
                            return $nextDate->copy()->subMonth()->endOfMonth()->startOfDay();
                        }else{
                            return $nextDate->copy()->endOfMonth()->startOfDay();
                        }
                    }
                return $nextDate->copy()->sub(new DateInterval('P1M')); // Mengurangkan 1 bulan
                break;
            case 'YEARLY':
                return $nextDate->copy()->sub(new DateInterval('P1Y')); // Mengurangkan 1 tahun
                break;
        }
    }
    public function nextTransaction($AppointmentId,$userid,$lastDate,$companyid){ 
        //Loop Jika Notrans Duplikat
        $attempts = 500; // Batas percobaan maksimum
        $attemptCount = 0;
        loopDuplikat:
        
        // note: jika lastdate tidak ada maka tidak ada recuren
        $controller = new Controller;
        $notrans = $controller->getNoTrans($companyid);

        $tblagenda = tblagenda::find($AppointmentId);
        if($lastDate == null){
            $nextDate = Carbon::parse(tblagenda::find($AppointmentId)->StartDate);
        }else{
            $nextDate = $this->nextAppointment($tblagenda->StartDate,$tblagenda->RecurrenceRule,$tblagenda->RecurrenceException,$lastDate,false);
        }
        if($nextDate != false){
            $cekIssetTrans = tbltrans::where('jatuhTempoTagihan',$nextDate)
                                        ->where('companyid',$companyid)
                                        ->where('userid',$userid)
                                        ->where('AppointmentId',$AppointmentId)
                                        ->where('statusid','<>',4)
                                        ->where('statusid','<>',7)
                                        ->first();
            $cekIsUsingBilling = tblbilling::where('userid',$userid)
                                            ->where('AppointmentId',$AppointmentId)
                                            ->where('statusid','<>',4)
                                            ->first();
            // $log = new Controller;
            // $log->savelog(json_encode($cekIssetTrans));
            if(!isset($cekIssetTrans)){ //Jika sudah ada jangan buat transaksi tagihan
                if (isset($cekIsUsingBilling)) {// Jika memiliki billing, buatkan transaksi
                    try {
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
                            'SBunga' => ($tblagenda->Pokok * $tblagenda->BungaPercent / 100),
                            'SLateFee' => 0,
                            'transdate' => $this->transDate($tblagenda->RecurrenceRule,$nextDate),
                            'jatuhTempoTagihan' => $nextDate,
                            'UserInsert' => $userid,
                            'InsertDT' => now(config('app.GMT')),
                            'UserUpdate' => $userid,
                            'UpdateDT' => now(config('app.GMT')),
                        ]);
                    } catch (\Throwable $th) {
                        $attemptCount++;
            
                        if ($attemptCount >= $attempts) {
                            // Batas percobaan maksimum tercapai
                            //dd("Limit ". $attempts ." Tercapai.");
                            return false;
                        }
            
                        goto loopDuplikat;
                    }
                    $chtController = new ChatController;
                    $chtController->GlobalPush("renderGlobal",$userid);
                    return true;
                }
            }
        }
        $chtController = new ChatController;
        $chtController->GlobalPush("renderGlobal",$userid);
        return false;
    }
    public function getbill(){
        $data = DB::select("SELECT t.statusid, t.notrans, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, p.productName, DATEDIFF(DAY, t.jatuhTempoTagihan, GETDATE()) as selisih
                            FROM tbltrans t
                            JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                            JOIN tblmasterproduct p ON p.productCode=a.productCode
                            WHERE t.SPokok + t.SBunga + t.SLateFee <> 0 AND t.statusid IN (5,6,11) AND t.userid = '".session('UIDGlob')->userid."'
                            ORDER BY text, t.jatuhTempoTagihan ASC");
        return $data;
    }
    public function gettransaction(Request $request){
        if($request->type != 'c'){
            return DB::select("SELECT u.nama, t.notrans, t.transdate, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName
                FROM tbltrans t
                JOIN tblstatus s ON t.statusid=s.statusid
                JOIN tbluser u ON u.userid=t.userid
                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                JOIN tblmasterproduct p ON p.productCode=a.productCode
                LEFT JOIN tblpaymentmethod ON t.paymentid=tblpaymentmethod.paymentid
                WHERE t.statusid != 4 AND t.companyid IN (SELECT value FROM STRING_SPLIT(u.companyidArray, ',')) AND t.userid = ".session('UIDGlob')->userid);
        }else{
            //My Customer Billing
            return DB::select("SELECT u.nama, t.notrans, t.transdate, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName
                FROM tbltrans t
                JOIN tblstatus s ON t.statusid=s.statusid
                JOIN tbluser u ON u.userid=t.userid
                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                JOIN tblmasterproduct p ON p.productCode=a.productCode
                LEFT JOIN tblpaymentmethod on t.paymentid=tblpaymentmethod.paymentid
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
            $user = tbluser::find(session('UIDGlob')->userid);
            $status = 1;
            if($tbltrans->statusid != 13){
                if($tbltrans->statusid == 5 || $tbltrans->statusid == 11){
                    if($user->companyid != $tbltrans->companyid){
                        //MELAKUKAN PEMBAYARAN
                        if ($request->hasFile('files')) {
                            if($request->paymentid == null){
                                $status = 4;
                            }
                            $path = storage_path('app/public/user/'.$user->userid.'/notrans/'.$request->notrans.'.*');
                            $files = glob($path);
                            foreach($files as $f){
                                File::delete($f);
                            }
                            $file = $request->file('files');
                            $exten = $file->getClientOriginalExtension();
                            $file->storeAs('public/user/'.$user->userid.'/notrans', $request->notrans.'.'.$exten);
                            $tbltrans->update(['statusid' => 6, 'isreject' => 0, 'paymentid' => $request->paymentid]);
                            $Up = tbluser::where('companyid',$tbltrans->companyid)->first();
                            $chatcontroller->GlobalPush("notif",$Up->userid);
                        }else{
                            $status = 0;
                        }
                    }else{
                        $status = 2;
                    }
                }else if($tbltrans->statusid == 6){
                    if($user->companyid == $tbltrans->companyid){
                        if($request->reject == 1){
                            //TOLAK PEMBAYARAN
                            $tbltrans->update([
                                'isreject' => 1, 
                                'statusid' => 5, 
                                'UserUpdate' => $user->userid,
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
                                'UserInsert' => $user->userid,
                                'InsertDT' => Carbon::now(config('app.GMT')),
                                'UserUpdate' => $user->userid,
                                'UpdateDT' => Carbon::now(config('app.GMT')),
                            ]);
                            $this->nextTransaction($tbltrans->AppointmentId,$tbltrans->userid,$tbltrans->jatuhTempoTagihan,$user->companyid);
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
    public function sendPaymentRequest()
    {
        $payload = [
            'transaction_type' => 'off-us',
            'transaction_time' => '2023-10-17 14:53:15',
            'transaction_status' => 'settlement',
            'transaction_id' => '7502a437-f280-4323-bf30-18bd83174a19',
            'status_message' => 'midtrans payment notification',
            'status_code' => '200',
            'signature_key' => 'b6402ff061b67e1960e2cc51b4aed1c494a07e5a7458919d6485d88ae594062a7457166bde557436f33dbd96761e6d2aa321822a4811f38245f22c92ab866f6c',
            'settlement_time' => '2023-10-17 14:54:09',
            'payment_type' => 'qris',
            'order_id' => '1SU23101700024',
            'merchant_id' => 'G191353295',
            'issuer' => 'BCA',
            'gross_amount' => '10000.00',
            'fraud_status' => 'accept',
            'expiry_time' => '2023-10-17 15:08:15',
            'currency' => 'IDR',
            'acquirer' => 'gopay',
        ];

        $url = 'http://192.168.36.12:8080/sisbilling9/paymentWebHook'; // Gantilah dengan URL yang sesuai

        $client = new Client();

        // Kirim permintaan POST
        $response = $client->post($url, [
            'json' => $payload,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response->getBody();
    }
    public function paymentWebHook(Request $request){
        if (null !== tblpaymenttrans::where('notrans', $request->order_id)->first()) {
            return [
                'status' => 200,
                'msg' => "Transaction Finish",
                'order' => $request->order_id,
            ];
        }
        $controller = new Controller;
        $pusher = $controller->setupPUSHER();
        $controller->savelog(Carbon::now(config('app.GMT')).' WeebHook MID : '. json_encode($request->all()));
        $transG = null;
        $snapToken = null;
        try {
            DB::beginTransaction();
            $tbltrans = tbltrans::find($request->order_id);
            $user = tbluser::find($tbltrans->userid);
            if(isset($request->type)){
                $this->expirePayment($request->order_id,$user);
            }
            $MID = $this->cekstatusMID($request->order_id);
            if($MID->status_code == 404){// 404 TRANSAKSI TIDAK DITEMUKAN
                $trans = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan','tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
                                ->addSelect(DB::raw('(SELECT COUNT(notrans) FROM tbltrans s WHERE AppointmentId = tbltrans.AppointmentId AND userid = tbltrans.userid AND jatuhTempoTagihan <= tbltrans.jatuhTempoTagihan) as angsuran'))
                                ->join('tbluser','tbluser.userid','=','tbltrans.userid')
                                ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
                                ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
                                ->where('notrans',$request->order_id)->first();
                $midtrans = new CreateSnapTokenService($trans);
                $snapToken = $midtrans->getSnapToken();
                $tbltrans->update(['snap_token' => $snapToken]);
                $data['type'] = "midtransHook";
                $data['authuser'] = $tbltrans->userid;
                $data['transG'] = $transG;
                $data['snapToken'] = $snapToken;
                $data['status'] = $MID->status_code;
                $data['msg'] = "Tagihan Akan Digenerate Ulang, Mohon Buka Kembali";
                $pusher->trigger('my-channel', 'my-event', $data);
                return [
                    'status' => 200,
                    'msg' => "Transaction Generate",
                ];
            }
            if($tbltrans->statusid != 13){
                $cid = explode(',', $user->companyidArray);
                array_pop($cid);
                if (in_array($tbltrans->companyid, $cid) && $MID->status_code == '200' && $MID->transaction_status == 'settlement') {
                    //KONFIRMASI PEMBAYARAN SUCCESS
                    $this->MIDsuccess($tbltrans,$MID->payment_type,$user);
                }
                if($MID->status_code == '201'){
                    $statusTrans = 11 ; // Pending Midtrans
                }else{
                    $statusTrans = $tbltrans->statusid;
                }
                if($MID->status_code == 407){// Expire midtrans
                    $trans = $this->MIDexpire($tbltrans,$user);
                    $MID = $this->cekstatusMID($request->order_id);
                    $transG = $trans->notrans;
                    $snapToken = $trans->snapToken;
                    $statusTrans = 4;
                }
                $tbltrans->update([
                    'statusid' => $statusTrans, 
                    'MIDstatus' => $MID->status_code, 
                    'MIDstatusmsg' => isset($MID->transaction_status)?$MID->transaction_status:'', 
                    'MIDUpdateUser' => $user->userid,
                    'MIDpaymenttype' => isset($MID->payment_type)?$MID->payment_type:'',
                    'MIDall' => json_encode($MID),
                ]);
                DB::commit();
                $data['type'] = "midtransHook";
                $data['authuser'] = $tbltrans->userid;
                $data['transG'] = $transG;
                $data['snapToken'] = $snapToken;
                $data['status'] = $MID->status_code;
                $data['msg'] = isset($MID->transaction_status)?$MID->transaction_status:'';
                $pusher->trigger('my-channel', 'my-event', $data);
                return [
                    'status' => 200,
                    'msg' => "Transaction Commit",
                ];
            }
            $data['type'] = "midtransHook";
            $data['authuser'] = $tbltrans->userid;
            $data['transG'] = null;
            $data['snapToken'] = null;
            $data['status'] = null;
            $data['msg'] = "Tagihan Tidak Berlaku";
            $pusher->trigger('my-channel', 'my-event', $data);
            
            return [
                'status' => 200,
                'msg' => "Transaction Commit",
            ];
            
        }catch (\Exception $e) {
            DB::rollBack();
            $controller->savelog(Carbon::now(config('app.GMT')).' WeebHook MID Err: '. json_encode($e));
            $tbltrans->update(['statusid' => 5,'paymentid' => 2]); //12
            return [
                'status' => 404,
                'msg' => "Transaction Rollback",
            ];
        }
    }
    public function confirmPembayaranMID(Request $request){
        $transG = null;
        $snapToken = null;
        // try {
        //     DB::beginTransaction();
            
            $tbltrans = tbltrans::find($request->notrans);
            $user = tbluser::find($tbltrans->userid);
            if(isset($request->type)){
                $this->expirePayment($request->notrans,$user);
            }
            $MID = $this->cekstatusMID($request->notrans);
            if($MID->status_code == 404){// 404 TRANSAKSI TIDAK DITEMUKAN
                $trans = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan','tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
                                ->addSelect(DB::raw('(SELECT COUNT(notrans) FROM tbltrans s WHERE AppointmentId = tbltrans.AppointmentId AND userid = tbltrans.userid AND jatuhTempoTagihan <= tbltrans.jatuhTempoTagihan) as angsuran'))
                                ->join('tbluser','tbluser.userid','=','tbltrans.userid')
                                ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
                                ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
                                ->where('notrans',$request->notrans)->first();
                $midtrans = new CreateSnapTokenService($trans);
                $snapToken = $midtrans->getSnapToken();
                tbltrans::find($request->notrans)->update(['snap_token' => $snapToken]);
                return [
                    'transG' => $request->notrans,
                    'snapToken' => $snapToken,
                    'status' => $MID->status_code,
                    'msg' => "Tagihan Akan Digenerate Ulang, Mohon Buka Kembali", 
                ];
            }
            if($tbltrans->statusid != 13){
                $cid = explode(',', $user->companyidArray);
                array_pop($cid);
                if (in_array($tbltrans->companyid, $cid) && $MID->status_code == '200' && $MID->transaction_status == 'settlement') {
                    //KONFIRMASI PEMBAYARAN SUCCESS
                    $this->MIDsuccess($tbltrans,$MID->payment_type,$user);
                }
                if($MID->status_code == '201'){
                    $statusTrans = 11 ; // Pending Midtrans
                }else{
                    $statusTrans = $tbltrans->statusid;
                }
                if($MID->status_code == 407){// Expire midtrans
                    $trans = $this->MIDexpire($tbltrans,$user);
                    $MID = $this->cekstatusMID($request->notrans);
                    $transG = $trans->notrans;
                    $snapToken = $trans->snapToken;
                    $statusTrans = 4;
                }
                $tbltrans->update([
                    'statusid' => $statusTrans, 
                    'MIDstatus' => $MID->status_code, 
                    'MIDstatusmsg' => isset($MID->transaction_status)?$MID->transaction_status:'', 
                    'MIDUpdateUser' => $user->userid,
                    'MIDpaymenttype' => isset($MID->payment_type)?$MID->payment_type:'',
                    'MIDall' => json_encode($MID),
                ]);
                DB::commit();
                return [
                    'transG' => $transG,
                    'snapToken' => $snapToken,
                    'status' => $MID->status_code,
                    'msg' => isset($MID->transaction_status)?$MID->transaction_status:'', 
                ];
            }
            return [
                'transG' => null,
                'snapToken' => null,
                'status' => null,
                'msg' => "Tagihan Tidak Berlaku",
            ];
            
        // }catch (\Exception $e) {
        //     DB::rollBack();
        //     // dd($e); // hidupkan untuk debug
        //     $tbltrans->update(['statusid' => 5,'paymentid' => 2]); //12
        //     return [
        //         'status' => 404,
        //         'msg' => "Transaction Rollback",
        //     ];
        // }
    }
    private function expirePayment($notrans,$user)
    {
        try {
            $client = new Client(); 
            $url = config('app.URLmidv2').$notrans."/expire";
            $headers = [
                'Authorization' => 'Basic ' . base64_encode(config('app.serverKey') . ':'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            $cekTrans = tbltrans::find($notrans); // cek jika transaksi milik user tersebut
            if($cekTrans->userid == $user->userid){
                $response = $client->request('POST', $url, [
                    'headers' => $headers,
                ]);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200) {
                    return true;
                } else {
                    return false; //'Payment Expire Failed: ' . $data->message;
                }
            }
        } catch (\Throwable $th) {
            return false;
        }
        
    }
    private function MIDsuccess($tbltrans,$payType,$user){
        $tbltrans->update(['statusid' => 7,'paymentid' => 2]);
        tblpaymenttrans::create([
            'notrans' => $tbltrans->notrans,
            'paymentid' => 2, //midtrans
            'statusid' => $tbltrans->statusid,
            'tglBayar' => $tbltrans->transdate,
            'tglVerifikasi' => Carbon::now(config('app.GMT')) ,
            'payment_type' => $payType,
            'total' => $tbltrans->SPokok + $tbltrans->SBunga + $tbltrans->SLateFee,
            'totalPay' => $tbltrans->SPokok + $tbltrans->SBunga + $tbltrans->SLateFee,
            'UserInsert' => $user->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UserUpdate' => $user->userid,
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
    private function MIDexpire($tbltrans,$user){
        $tblcomp = tblcomp::find($tbltrans->companyid);
        $notransHeader = $tbltrans->companyid.strtoupper(substr($tblcomp->companyname, 0, 2)).Carbon::now(config('app.GMT'))->format('ymd');
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
            'notransExpire' => $tbltrans->notrans,
            'AppointmentId' => $tbltrans->AppointmentId,
            'companyid' => $tbltrans->companyid,
            'userid' => $tbltrans->userid,
            'statusid' => 5,
            'SisaPok' => $tbltrans->SisaPok,
            'Pokok' => $tbltrans->Pokok,
            'Bunga' => $tbltrans->Bunga,
            'LateFee' => $tbltrans->LateFee,
            'JHT' => $tbltrans->JHT,
            'SPokok' => $tbltrans->SPokok,
            'SBunga' => $tbltrans->SBunga,
            'SLateFee' => $tbltrans->SLateFee,
            'transdate' => $tbltrans->transdate,
            'snap_token' => null,
            'jatuhTempoTagihan' => $tbltrans->jatuhTempoTagihan,
            'UserInsert' => $user->userid,
            'InsertDT' => now(config('app.GMT')),
            'UserUpdate' => $user->userid,
            'UpdateDT' => now(config('app.GMT')),
        ]);
        $trans = tbltrans::select('notrans','tblcomp.companyname','tblagenda.text','tbluser.userid','tbluser.nama','tbluser.email','tbluser.hp','tbluser.alamatSingkat','tbltrans.companyid','tbltrans.statusid','jatuhTempoTagihan' ,'tbltrans.Pokok',DB::raw('tbltrans.SPokok + tbltrans.SBunga + tbltrans.SLateFee as Amount'),DB::raw('CONCAT(tblagenda.productCode, tblagenda.companyid) as kodebarang'))
        ->join('tbluser','tbluser.userid','=','tbltrans.userid')
        ->join('tblagenda','tblagenda.AppointmentId','=','tbltrans.AppointmentId')
        ->join('tblcomp','tblcomp.companyid','=','tblagenda.companyid')
        ->where('notrans',$notrans)->first();

        $midtrans = new CreateSnapTokenService($trans);
        $trans->snapToken = $midtrans->getSnapToken();
        $transNew->update(['snap_token' => $trans->snapToken]);
        return $trans;
    }
    public function cekstatusMID($notrans){
        $url = config('app.URLmidv2').$notrans.'/status';
        $headers = array(
            'Accept: application/json',
            // 'Authorization: Basic U0ItTWlkLXNlcnZlci03STQ3NGV6QUE4QXZiejlzT0VHTW81bnc6'
            'Authorization: Basic ' . base64_encode(config('app.serverKey') . ':')
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
            // 'Authorization: Basic U0ItTWlkLXNlcnZlci03STQ3NGV6QUE4QXZiejlzT0VHTW81bnc6'
            'Authorization: Basic ' . base64_encode(config('app.serverKey') . ':')
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
        $tbltrans = tbltrans::find($request->transG);
        $user = tbluser::find($tbltrans->userid);
        if($tbltrans->companyid != session('UIDGlob')->companyid){
            return "tidak bisa akses!";
        }
        $tbltrans->update([
            'statusid' => 13,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        $this->cancleMID($request->transG);
        $this->nextTransaction($tbltrans->AppointmentId,$tbltrans->userid,$tbltrans->jatuhTempoTagihan,$user->companyid);
        return "success";
    }
    private function sendMailPayment($array){
        $data = [
            'type' => 'mailpayment',
            'trans' => $array['trans'],
        ];
        Mail::to($array['email'])->send(new SendMail($data));
    }

    public function eod(){
        $sysDT = (tblsyspara::first()->sysDate != null) ? Carbon::parse(tblsyspara::first()->sysDate) : Carbon::parse('2022-01-01');
        $currentDate = Carbon::now(config('app.GMT'));
        if($sysDT->format('y-m-d') != $currentDate->format('y-m-d')){
            DB::update("UPDATE tbltrans SET 
            statusid = IIF(jht <> IIF(DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP) > 0, DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP),0),4,statusid),
            onEOD = IIF(jht <> IIF(DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP) > 0, DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP),0),1,0),
            jht = IIF(DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP) > 0, DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP),0), 
            SLateFee = LateFee * IIF(DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP) > 0, DATEDIFF(DAY, jatuhTempoTagihan, CURRENT_TIMESTAMP),0),
            SPokok = Pokok WHERE statusid = 5");
            
            $tbltranss = tbltrans::where('onEOD',1)->where('statusid',4)->get();
            foreach ($tbltranss as $tbltrans) {
                $user = tbltrans::find($tbltrans->userid);
                $this->MIDexpire($tbltrans,$user);
            }
            DB::update("UPDATE tbltrans SET onEOD = 0");
            $tblagenda = collect(DB::select("SELECT a.AppointmentId, t.companyid, t.userid, t.notrans,t.transdate,t.jatuhTempoTagihan,a.StartDate,a.RecurrenceRule,a.RecurrenceException FROM tblagenda a
                                            JOIN (SELECT AppointmentId, userid, companyid, MAX(notrans) AS notrans,MAX(transdate) AS transdate, max(jatuhTempoTagihan) as jatuhTempoTagihan FROM tbltrans
                                                    WHERE statusid <> 4
                                                    GROUP BY companyid, userid, AppointmentId) AS t ON a.AppointmentId=t.AppointmentId
                                            WHERE productCode IS NOT NULL and isBilling = 1
                                            AND a.statusid <> 4"));
            foreach ($tblagenda as $agenda) {
                $nextDate = $this->nextAppointment($agenda->StartDate,$agenda->RecurrenceRule,$agenda->RecurrenceException,$agenda->transdate,false);
                // $log = new Controller;
                if( Carbon::parse($nextDate)->format('ymd') == Carbon::now(config('GMT'))->format('ymd') ){
                    // $log->savelog('create dari jatuhtempo ' . $agenda->jatuhTempoTagihan );
                    $this->nextTransaction($agenda->AppointmentId,$agenda->userid,$agenda->jatuhTempoTagihan,$agenda->companyid);
                }
            }
            tblsyspara::first()->update(['sysDate' => Carbon::now(config('app.GMT'))]);
            return true;
        }
    }
}