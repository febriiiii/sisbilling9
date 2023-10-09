<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function pivot(Request $request){
        if($request->type =="mybilling"){
            if (substr(session('UIDGlob')->companyidArray, -1) === ',') {
                $cid = substr(session('UIDGlob')->companyidArray, 0, -1);
                $add =  " AND t.userid = ".session('UIDGlob')->userid;
            }
        }else{
            $cid = session('UIDGlob')->companyid;
            $add = "";
        }
        return DB::select("SELECT u.nama, pt.notrans,pt.payment_type,pt.total as TotalTagihanBank, pt.totalPay as TotalBayar, pt.tglBayar, t.jatuhTempoTagihan, p.productName, t.Pokok AS TotalTagihan
            FROM tbltrans t
            JOIN tblpaymenttrans pt ON pt.notrans=t.notrans
            JOIN tbluser u ON u.userid=t.userid
            JOIN tblstatus s ON t.statusid=s.statusid
            JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
            JOIN tblmasterproduct p ON p.productCode=a.productCode
            WHERE t.statusid != 4 AND t.companyid IN (".$cid.")".$add);
    }
}
