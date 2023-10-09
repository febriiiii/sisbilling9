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
        $or = "";
        if(session('UIDGlob')->companyidArray != null){
            $or = "OR PATINDEX('%[".session('UIDGlob')->companyid."]%', companyidArray) > 0";
        }
        $compArray = substr(session('UIDGlob')->companyidArray, 0, -1);
        if(session('UIDGlob')->userid == 1){
            return DB::select("SELECT nama,userid FROM tbluser where userid <> 1"); 
        }
        return DB::select("SELECT nama,userid FROM tbluser where companyid in (".$compArray.") ".$or);
    }
    
    public function tblcomp(){
        return tblcomp::where('companyid','!=',1)->get();
    }
}
