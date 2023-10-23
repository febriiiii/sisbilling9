<?php

namespace App\Http\Controllers;

use App\Models\tblchat;
use App\Models\tblcomp;
use App\Models\tblmasterproduct;
use App\Models\tblproducttype;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function tblproducttype(){
        return tblproducttype::where('statusid','!=',4)->whereIn('companyid',[1,session('UIDGlob')->companyid])->get();
    }
    public function tblmasterproduct(){
        return tblmasterproduct::where('statusid','!=',4)->where('companyid',session('UIDGlob')->companyid)->get();
    }  
    public function appoinmentbill(Request $request){
        return DB::select("SELECT a.AppointmentId,a.text,a.description,m.productCode,m.productName,a.RecurrenceRule,a.StartDate 
                    FROM tblagenda a
                    JOIN tblmasterproduct m ON a.productCode=m.productCode AND a.companyid=m.companyid
                    WHERE a.companyid = ".session('UIDGlob')->companyid);
    }
    public function appoinmentbillInfo(Request $request){
        return DB::select("SELECT a.AppointmentId,a.text,a.description,m.productCode,m.productName,a.RecurrenceRule,a.StartDate 
                    FROM tblagenda a
                    JOIN tblmasterproduct m ON a.productCode=m.productCode
                    WHERE a.AppointmentId = ".$request->AppointmentId)[0];
    }
    public function chatHeader(){
        $id = session('UIDGlob')->userid;
        $query = "SELECT distinct sub1.nama, sub1.userid from tbluser sub
                            JOIN (
                            SELECT * FROM tbluser
                            ) sub1 on CHARINDEX(IIF(CONCAT(sub1.companyid,',') = ',','',CONCAT(sub1.companyid,',')), sub.companyidArray) > 0 or sub1.companyid = 1
                            WHERE sub1.userid <> sub.userid and sub.userid={$id}
                    UNION
                    SELECT distinct sub1.nama, sub1.userid from tbluser sub
                            JOIN (
                            SELECT * FROM tbluser
                            ) sub1 on CHARINDEX(IIF(CONCAT(sub.companyid,',') = ',','',CONCAT(sub.companyid,',')), sub1.companyidArray) > 0 or sub1.companyid = 1
                            WHERE sub1.userid <> sub.userid and sub.userid={$id}";
        return DB::select($query);
    }
    // CASE
    // WHEN LEN(companyid) > 0 THEN
    //     CONCAT('[', LEFT(companyid, 1), ']', 
    //     CASE WHEN LEN(SUBSTRING(companyid, 2, 1)) > 0 THEN CONCAT('[', SUBSTRING(companyid, 2, 1), ']') ELSE '' END,
    //     CASE WHEN LEN(SUBSTRING(companyid, 3, 1)) > 0 THEN CONCAT('[', SUBSTRING(companyid, 3, 1), ']') ELSE '' END,
    //     CASE WHEN LEN(SUBSTRING(companyid, 4, 1)) > 0 THEN CONCAT('[', SUBSTRING(companyid, 4, 1), ']') ELSE '' END,
    //     CASE WHEN LEN(companyid) > 0 THEN '[,]' ELSE '' END)
    // ELSE '' 
    public function tblcomp(){
        return tblcomp::where('companyid','!=',1)->get();
    }
}
