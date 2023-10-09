<?php

namespace App\Http\Controllers;

use App\Models\tblagenda;
use App\Models\tblbilling;
use App\Models\tblmasterproduct;
use App\Models\tbltrans;
use App\Models\tbluser;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Double;

class AgendaController extends Controller
{
    public function getAgenda(Request $request)
    {        
        $array = explode(",", session('UIDGlob')->companyidArray);
        array_pop($array);
        $agendas = tblagenda::whereIn('companyid', $array)
                    ->whereIn('AppointmentId', function ($query) {
                        $query->select('t.AppointmentId')
                            ->from('tbltrans as t')
                            ->join('tblagenda as ag', 't.AppointmentId', '=', 'ag.AppointmentId')
                            ->where('t.userid', session('UIDGlob')->userid)
                            ->groupBy('t.AppointmentId');
                    })
                    ->orWhere('userid', session('UIDGlob')->userid)
                    ->get();
        return $agendas;
    }

    public function getproduct(){
            $product = tblmasterproduct::select('productCode as id','productName as text')
                        ->where('statusid','!=', 4)
                        ->where('companyid', session('UIDGlob')->companyid)
                        ->get();
        return $product;
    }
    public function getUserPinjam(Request $request){
        $AppointmentId = $request->AppointmentId;
        if($AppointmentId == null){
            $AppointmentId = 0;
        }
        $compid = session('UIDGlob')->companyid;
        return DB::select("SELECT nama, u.userid, email, CASE WHEN b.AppointmentId IS NULL THEN 0 ELSE 1 END AS isUsed
                            FROM tbluser u
                            LEFT JOIN (SELECT * FROM tblbilling WHERE AppointmentId = ".$AppointmentId.") b ON b.userid = u.userid
                            WHERE PATINDEX('%[".$compid."]%', companyidArray) > 0");
    }
    public function getAgendaPinjam(Request $request){
        return DB::select("SELECT a.AppointmentId,Text,Pokok, CASE WHEN b.AppointmentId IS NULL THEN 0 ELSE 1 END AS isUsed
                            FROM tblagenda a
                            LEFT JOIN (SELECT * FROM tblbilling WHERE userid = ".$request->userid.") b ON b.AppointmentId = a.AppointmentId
                            WHERE isBilling = 1 AND companyid = ". session('UIDGlob')->companyid);
    }
    public function putUserPinjam(Request $request){
        $values = json_decode($request->values);
        if(isset($request->AppointmentId)){
            if($values->isUsed == 1){
                $this->createTrans($request->key,$request->AppointmentId);
            }else{
                tblbilling::where('userid',$request->key)->where('AppointmentId',$request->AppointmentId)->delete();
                $data = tbltrans::where('AppointmentId',$request->AppointmentId)->where('userid',$request->key)->where('statusid',5)->get();
                foreach ($data as $d) {
                    $d->update(['statusid' => 4, 'UserUpdate' => session('UIDGlob')->userid, 'UpdateDT' => Carbon::now(config('app.GMT'))]);
                }
            }
        }
        $chatcontroller = new ChatController;
        $chatcontroller->GlobalPush("renderMyBilling",$request->key);
        return true;
    }
    public function getpokok(Request $request){
        return DB::select("select top 1 a.*, (select productName from tblmasterproduct where productCode = a.productCode) as produk from tblagenda a where AppointmentId = ".$request->AppointmentId);
    }
    public function putAgendaPinjam(Request $request){
        $values = json_decode($request->values);
        if(isset($request->key)){
            if($values->isUsed == 1){
                $this->createTrans($request->userid,$request->key);
            }else{
                tblbilling::where('userid',$request->userid)->where('AppointmentId',$request->key)->delete();
                $data = tbltrans::where('AppointmentId',$request->key)->where('userid',$request->userid)->where('statusid',5)->get();
                foreach ($data as $d) {
                    $d->update(['statusid' => 4, 'UserUpdate' => session('UIDGlob')->userid, 'UpdateDT' => Carbon::now(config('app.GMT'))]);
                }
            }
        }
        $chatcontroller = new ChatController;
        $chatcontroller->GlobalPush("renderMyBilling",$request->key);
        return true;
    }
    public function updateagendabill(Request $request){
        $data = tblagenda::find($request->AppointmentId);
        $data->update([
            'description' => $request->description,
            'Pokok' => (Double) $request->Pokok,
            'bungaPercent' => (Double) $request->bungaPercent,
            'lateFeePercent' => (Double) $request->lateFeePercent,
        ]);
    }
    public function dataStatus(){
        return DB::select("SELECT max(a.AppointmentId) as id, max(text) as title,max(jatuhTempoTagihan) as date,t.statusid
                            FROM tbltrans t
                            join tblagenda a on t.AppointmentId=a.AppointmentId
                            where t.userid = '".session('UIDGlob')->userid."'
                            group by t.statusid, t.AppointmentId ORDER BY t.statusid ASC");
    }
    public function insertAgenda(Request $request)
    {
        $values = json_decode($request->values);
        $datetime = new DateTime($values->StartDate);
        $interval = new DateInterval('PT7H');
        $datetime->add($interval);
        $start = $datetime->format('Y-m-d\TH:i:s\Z');

        $datetime2 = new DateTime($values->EndDate);
        $interval2 = new DateInterval('PT7H');
        $datetime2->add($interval2);
        $end = $datetime2->format('Y-m-d\TH:i:s\Z');
        $allday = '';
        if(isset($values->all_day)){
            $allday = $values->all_day;
            if($values->all_day == 0){
                $allday = '';
            }
        }
        $apoinmentid = tblagenda::insertGetId([
            'Text' => $values->Text,
            'userid' => session('UIDGlob')->userid,
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
            'statusid' => 1,
            'isBilling' => isset($values->Billing)? $values->Billing : 0,
            'productCode' => isset($values->productCode)? $values->productCode : '',
            'Pokok' => isset($values->Pokok)? $values->Pokok : '',
            'lateFeePercent' => isset($values->lateFeePercent)? $values->lateFeePercent : '',
            'BungaPercent' => isset($values->BungaPercent)? $values->BungaPercent : '',
            'companyid' => session('UIDGlob')->companyid,
            'StartDate' => $start,
            'EndDate' => $end,
            'description' => isset($values->description)? $values->description : '',
            'RecurrenceRule' => isset($values->RecurrenceRule)? $values->RecurrenceRule : '',
            'RecurrenceException' => isset($values->RecurrenceException)? $values->RecurrenceException : '',
            'all_day' => $allday,
        ]);
        if(isset($values->Billing) && $values->Billing){
            if(isset($values->tempUserpinjam)){
                foreach ($values->tempUserpinjam as $u) {
                    $this->createTrans($u,$apoinmentid);
                }
            }
        }
        return true;
    }
    public function createTrans($userid,$apoinmentid){
        $Ntrans = new TransactionController;
        $tblagenda = tblagenda::find($apoinmentid);

        tblbilling::create([
            'userid' => $userid,
            'AppointmentId' => $apoinmentid,
            'statusid' => 1,
            'UserInsert' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
        ]);

        if($tblagenda->RecurrenceRule != ""){
            $freq = explode("=",explode(";",$tblagenda->RecurrenceRule)[0])[1];
            $Lastdate = Carbon::parse($tblagenda->StartDate);
            while ($Lastdate < Carbon::now(config('app.GMT'))) {
                if ($freq === 'HOURLY') {
                    $Lastdate->addHour();
                } elseif ($freq === 'DAILY') {
                    $Lastdate->addDay();
                } elseif ($freq === 'WEEKLY') {
                    $Lastdate->addWeek();
                } elseif ($freq === 'MONTHLY') {
                    $Lastdate->addMonth();
                } elseif ($freq === 'YEARLY') {
                    $Lastdate->addYear();
                }
            }  
            if ($freq === 'HOURLY') {
                $Lastdate->subHour();
            } elseif ($freq === 'DAILY') {
                $Lastdate->subDay();
            } elseif ($freq === 'WEEKLY') {
                $Lastdate->subWeek();
            } elseif ($freq === 'MONTHLY') {
                $Lastdate->subMonth();
            } elseif ($freq === 'YEARLY') {
                $Lastdate->subYear();
            }    
            $Ntrans->nextTransaction($apoinmentid,$userid,$Lastdate,session('UIDGlob')->companyid);
        }else{
            $Ntrans->nextTransaction($apoinmentid,$userid,null,session('UIDGlob')->companyid);
        }
    }

    public function putAgenda(Request $request)
    {
        $tblagenda = tblagenda::find($request->key);
        if($tblagenda->userid != session('UIDGlob')->userid){
            return false;
        }
        $values = json_decode($request->values);
        $PTH = "PT7H";
        if(isset($values->RecurrenceException)){
            if($tblagenda->RecurrenceException != $values->RecurrenceException){
                $PTH = "PT0H";
            }
        }
        $datetime = new DateTime($values->StartDate);
        $interval = new DateInterval($PTH);
        $datetime->add($interval);
        $start = $datetime->format('Y-m-d\TH:i:s\Z');

        $datetime2 = new DateTime($values->EndDate);
        $interval2 = new DateInterval($PTH);
        $datetime2->add($interval2);
        $end = $datetime2->format('Y-m-d\TH:i:s\Z');
        
        $allday = '';
        if(isset($values->all_day)){
            $allday = $values->all_day;
            if($values->all_day == 0){
                $allday = '';
            }
        }
        $tblagenda->update([
            'Text' => $values->Text,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(),
            'UpdateDT' => Carbon::now(config('app.GMT')),
            'statusid' => 1,
            'isBilling' => isset($values->Billing)? $values->Billing : 0,
            'Pokok' => isset($values->Pokok)? $values->Pokok : '',
            'lateFeePercent' => isset($values->lateFeePercent)? $values->lateFeePercent : '',
            'BungaPercent' => isset($values->BungaPercent)? $values->BungaPercent : '',
            'productCode' => isset($values->productCode)? $values->productCode : '',
            'companyid' => session('UIDGlob')->companyid,
            'StartDate' => $start,
            'EndDate' => $end,
            'description' => isset($values->description)? $values->description : '',
            'RecurrenceRule' => isset($values->RecurrenceRule)? $values->RecurrenceRule : '',
            'RecurrenceException' => isset($values->RecurrenceException)? $values->RecurrenceException : '',
            'all_day' => $allday,
        ]);
        return true;
    }

    public function deleteAgenda(Request $request)
    {
        $tblagenda = tblagenda::find($request->key);
        if($tblagenda->userid != session('UIDGlob')->userid){
            return false;
        }
        $tblagenda->delete();
        return true;
    }

    
    public function dataMyagenda(Request $request)
    {
        return response()->json([
            'data' => DB::select("SELECT
                                    AppointmentId,
                                    Text,
                                    StartDate,
                                    description,
                                    productName,
                                    pokok,
                                    CASE
                                        WHEN CHARINDEX('FREQ=', RecurrenceRule) > 0 THEN
                                            SUBSTRING(RecurrenceRule, CHARINDEX('FREQ=', RecurrenceRule) + LEN('FREQ='), CHARINDEX(';', RecurrenceRule, CHARINDEX('FREQ=', RecurrenceRule) + LEN('FREQ=')) - (CHARINDEX('FREQ=', RecurrenceRule) + LEN('FREQ=')))
                                        ELSE
                                            ''
                                    END AS frequency
                                FROM
                                    tblagenda a
                                JOIN
                                    tblmasterproduct p ON p.productCode = a.productCode AND p.companyid = a.companyid
                                WHERE isBilling = 1;"),
            'totalCount' => DB::select("SELECT COUNT(*) as aggregate FROM tblagenda")[0]->aggregate,
        ]);
    }
}