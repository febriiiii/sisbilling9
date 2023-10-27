<?php

namespace App\Http\Controllers;

use App\Models\tblmasterproduct;
use App\Models\tblpaketakun;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function adminlistpengelola() {
        return view('admin.listpengelola');
    }
    public function admintagihan() {
        return view('admin.tagihan');
    }
    public function adminpembayaran() {
        return view('admin.pembayaran');
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
                    'Un Link' as billAktif,
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
    public function dataPembayaran(){
        return DB::select("SELECT u.nama, t.notrans, t.transdate, CASE WHEN t.paymentid = 2 THEN MIDpaymenttype ELSE paymentName END AS paymentname, t.jatuhTempoTagihan,t.SPokok + t.SBunga + t.SLateFee AS Amount, s.deskripsi, p.productName
                FROM tbltrans t
                JOIN tblstatus s ON t.statusid=s.statusid
                JOIN tbluser u ON u.userid=t.userid
                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                JOIN tblmasterproduct p ON p.productCode=a.productCode
                LEFT JOIN tblpaymentmethod on t.paymentid=tblpaymentmethod.paymentid
                WHERE t.statusid != 4 AND u.companyid IS NOT NULL AND u.superadmin <> 1");
    }
}
