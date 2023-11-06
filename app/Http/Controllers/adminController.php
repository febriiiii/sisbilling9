<?php

namespace App\Http\Controllers;

use App\Models\tblagenda;
use App\Models\tblbilling;
use App\Models\tblmasterproduct;
use App\Models\tblpaketakun;
use App\Models\tbltrans;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function adminlistpengelola() {
        return view('admin.listpengelola');
    }
    public function admintagihan() {
        return view('admin.tagihan');
    }
    public function adminpembayaran(Request $request) {
        $userid = $request->userid;
        return view('admin.pembayaran',compact('userid'));
    }
    public function updateisAktif(Request $request){
        tbluser::find($request->userid)->update(['isAktif' => $request->val]);
        return true;
    }
    public function dataPengelola(Request $request){
        $selected = "tbluser.userid,
                    tbluser.nama, 
                    tbluser.email as emailU, 
                    tbluser.alamatLengkap as alamatU, 
                    tblcomp.companyname, 
                    tblcomp.email as emailP, 
                    tblcomp.companyaddress as alamatP,
                    (SELECT top 1 t.notrans
                        FROM tbltrans t
                        JOIN tblstatus s ON t.statusid=s.statusid
                        JOIN tbluser u ON u.userid=t.userid
                        JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                        JOIN tblmasterproduct p ON p.productCode=a.productCode
                        WHERE t.statusid != 4 AND p.isSubscribe = 1 AND t.userid=tbluser.userid) as billAktif,
                    isAktif";
        $from = "tbluser";
        $join = "JOIN tblcomp ON tblcomp.companyid=tbluser.companyid";
        $where = "WHERE tbluser.statusid != 4 AND tbluser.companyid IS NOT NULL AND tbluser.superadmin <> 1";
        
        $controller = new Controller;
        return $controller->grid($selected,$from,$join,$where,$request);
    }
    public function dataTagihan(Request $request){
        $selected = "*";
        $from = "tblmasterproduct";
        $join = "";
        $where = "WHERE statusid <> 4 AND isSubscribe = 1";
        
        $controller = new Controller;
        return $controller->grid($selected,$from,$join,$where,$request);
    }
    public function dataTagihanInsert(Request $request)
    {
        $productCode = isset($request->values['productCode'])?$request->values['productCode']:'';
        if(tblmasterproduct::where('productCode',$productCode)->first()){
            return 0;
        }
        $data = [
            'isSubscribe' => 1,
            'companyid' => 1,
            'producttypeid' => 1,
            'productName' => $request->values['productName'],
            'price' => $request->values['price'],
            'rangeDuration' => $request->values['rangeDuration'],
            'duration' => $request->values['duration'],
            'statusid' => 1,
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ];
        tblmasterproduct::create($data);
        return response()->json(['success' => true]);
    }

    public function dataTagihanUpdate(Request $request)
    {
        $values = $request->values;
        $values['UserUpdate'] = session('UIDGlob')->userid;
        $values['UpdateDT'] = Carbon::now(config('app.GMT'));
        $builder = tblmasterproduct::where('productCode',$request->productCode)->first();
        $builder->update($values);
        return response()->json(['success' => true]);
    }
    public function dataTagihanDelete(Request $request){
        $builder = tblmasterproduct::where('productCode',$request->productCode)->first();
        $builder->update([
            'statusid' => 4,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        return true;
    }
    public function dataPembayaran(Request $request){
        $where = "";
        if($request->userid != ''){
            $where = " AND t.userid=".$request->userid." ";
        }
        return DB::select("SELECT u.nama, t.notrans, t.transdate, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName
                FROM tbltrans t
                JOIN tblstatus s ON t.statusid=s.statusid
                JOIN tbluser u ON u.userid=t.userid
                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                JOIN tblmasterproduct p ON p.productCode=a.productCode
                LEFT JOIN tblpaymentmethod on t.paymentid=tblpaymentmethod.paymentid
                WHERE t.statusid != 4 AND u.companyid IS NOT NULL AND u.superadmin <> 1 {$where}");
    }
    public function subscribe(Request $request){
        $this->createSubscribe($request->productCode,$request->userid);
    }
    public function createSubscribe($productCode,$userid){
        $produk = tblmasterproduct::find($productCode);
        $now = Carbon::now(config('app.GMT'));
        $finishDt = DB::select("SELECT MAX(
                                CASE 
                                    WHEN p.duration = 'Hari' THEN DATEADD(DAY, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                    WHEN p.duration = 'Minggu' THEN DATEADD(WEEK, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                    WHEN p.duration = 'Bulan' THEN DATEADD(MONTH, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                    WHEN p.duration = 'Tahun' THEN DATEADD(YEAR, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                END ) AS FinishDate
                                FROM tbltrans t
                                JOIN tblstatus s ON t.statusid=s.statusid
                                JOIN tbluser u ON u.userid=t.userid
                                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                                JOIN tblmasterproduct p ON p.productCode=a.productCode
                                LEFT JOIN tblpaymentmethod on t.paymentid=tblpaymentmethod.paymentid
                                WHERE t.statusid != 4 AND p.isSubscribe = 1 AND t.userid = {$userid}");
        if($finishDt[0]->FinishDate != null){
            $finishDt = Carbon::parse($finishDt[0]->FinishDate)->setTime(0, 0, 0);
        }else{
            $finishDt = $now;
        }

        $recur ='FREQ=DAILY;COUNT=1';
        if($produk->duration == 'Minggu'){
            $recur ='FREQ=WEEKLY;COUNT=1';
        }else if($produk->duration == 'Bulan'){
            $recur ='FREQ=MONTHLY;COUNT=1';
        }else if($produk->duration == 'Tahun'){
            $recur ='FREQ=YEARLY;COUNT=1';
        }
        $agenda = [
            'Text' => $produk->productName,
            'userid' => 1,
            'UserInsert' => 1,
            'UserUpdate' => 1,
            'InsertDT' => $now,
            'UpdateDT' => $now,
            'statusid' => 1,
            'isBilling' => 1,
            'productCode' => $productCode,
            'Pokok' => $produk->price,
            'lateFeePercent' => 0,
            'BungaPercent' => 0,
            'companyid' => 1,
            'StartDate' => $finishDt->format('Y-m-d\TH:i:s\Z'),
            'EndDate' => $finishDt->format('Y-m-d\TH:i:s\Z'),
            'description' => $produk->productName,
            'RecurrenceRule' => $recur,
            'RecurrenceException' => '',
            'all_day' => 1,
        ];
        $apoinmentid = tblagenda::insertGetId($agenda);

        tblbilling::create([
            'userid' => $userid,
            'AppointmentId' => $apoinmentid,
            'statusid' => 1,
            'UserInsert' => 1,
            'InsertDT' => $now,
        ]);
        $controller = new Controller;
        $notrans = $controller->getNoTrans(1);
        tbltrans::create([
            'notrans' => $notrans,
            'AppointmentId' => $apoinmentid,
            'companyid' => 1,
            'userid' => $userid,
            'statusid' => 5,
            'SisaPok' => $produk->price,
            'Pokok' => $produk->price,
            'Bunga' => 0,
            'LateFee' => 0,
            'JHT' => 0,
            'SPokok' => $produk->price,
            'SBunga' => 0,
            'SLateFee' => 0,
            'transdate' => $finishDt,
            'jatuhTempoTagihan' => $finishDt,
            'UserInsert' => 1,
            'InsertDT' => now(config('app.GMT')),
            'UserUpdate' => 1,
            'UpdateDT' => now(config('app.GMT')),
        ]);
        $chtController = new ChatController;
        $chtController->GlobalPush("renderGlobal",$userid);

        $tagihan = DB::select("SELECT TOP 1 t.AppointmentId, u.nama, t.notrans, t.transdate, a.description, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName,
                                CASE 
                                    WHEN p.duration = 'Hari' THEN DATEADD(DAY, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                    WHEN p.duration = 'Minggu' THEN DATEADD(WEEK, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                    WHEN p.duration = 'Bulan' THEN DATEADD(MONTH, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                    WHEN p.duration = 'Tahun' THEN DATEADD(YEAR, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                END AS FinishDate,
                                CASE
                                    WHEN GETDATE() BETWEEN t.jatuhTempoTagihan AND
                                    (
                                        SELECT
                                            CASE
                                                WHEN p.duration = 'Hari' THEN DATEADD(DAY, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                                WHEN p.duration = 'Minggu' THEN DATEADD(WEEK, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                                WHEN p.duration = 'Bulan' THEN DATEADD(MONTH, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                                WHEN p.duration = 'Tahun' THEN DATEADD(YEAR, CAST(p.rangeDuration AS INT), t.jatuhTempoTagihan)
                                            END
                                    ) THEN 'Ya'
                                    ELSE 'Tidak'
                                END AS Aktif
                                FROM tbltrans t
                                JOIN tblstatus s ON t.statusid=s.statusid
                                JOIN tbluser u ON u.userid=t.userid
                                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                                JOIN tblmasterproduct p ON p.productCode=a.productCode
                                LEFT JOIN tblpaymentmethod on t.paymentid=tblpaymentmethod.paymentid
                                WHERE t.notrans='{$notrans}'");

        return $tagihan;
    }

    public function unsubscribe(Request $request){
        tblagenda::where('AppointmentId',$request->AppointmentId)->first()->update(['statusid' => 4]);
        tblbilling::where('AppointmentId',$request->AppointmentId)->first()->update(['statusid' => 4]);
        tbltrans::where('AppointmentId',$request->AppointmentId)->first()->update(['statusid' => 4]);
        $chtController = new ChatController;
        $chtController->GlobalPush("renderGlobal",$request->userid);
        return true;
    }
}
