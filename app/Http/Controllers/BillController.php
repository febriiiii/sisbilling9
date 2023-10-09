<?php

namespace App\Http\Controllers;

use App\Models\tblagenda;
use App\Models\tblbilling;
use App\Models\tblcomp;
use App\Models\tbltrans;
use App\Models\tbltransd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function operator($operator, $query,$column,$escaped_value){
        switch ($operator) {
            case "contains":
                $query .= "".$column." LIKE '%".$escaped_value."%'";
                break;
            case "notcontains":
                $query .= "".$column." NOT LIKE '%".$escaped_value."%'";
                break;
            case "startswith":
                $query .= "".$column." LIKE '".$escaped_value."%'";
                break;
            case "endswith":
                $query .= "".$column." LIKE '%".$escaped_value."'";
                break;
            case "=":
            case "<>":
            case ">":
            case ">=":
            case "<":
            case "<=":
                $query .= "".$column." ".$operator." '".$escaped_value."'";
            break;
        }
        return $query;
    }

    public function dataBill(Request $request)
    {
        $where = "WHERE a.companyid = '".session('UIDGlob')->companyid."' AND b.statusid<>4 AND b.userid = ".$request->userid;

        // Set base query
        $query = "SELECT b.billingid,b.userid,b.AppointmentId,a.Pokok,b.InsertDT,b.UpdateDT FROM tblbilling b JOIN tblagenda a ON a.AppointmentId=b.AppointmentId ".$where." ";

        // Apply filtering
        $filter = json_decode($request->filter);
        if (isset($filter)) {
            $query = "SELECT b.billingid,b.userid,b.AppointmentId,a.Pokok,b.InsertDT,b.UpdateDT FROM tblbilling b JOIN tblagenda a ON a.AppointmentId=b.AppointmentId ".$where." AND ";
            if (is_array($filter[0])) {
                foreach ($filter as $f) {
                    if ($f != "and" && $f != "or") {
                        $column = $f[0];
                        $operator = $f[1];
                        $value = $f[2];
                        $escaped_value = str_replace("'", "''", $value);
                        $query = $this->operator($operator, $query,$column,$escaped_value);
                    }else{
                        $query .= " ".$f." ";
                    }
                }
            } else {
                $column = $filter[0];
                $operator = $filter[1];
                $value = $filter[2];
                $escaped_value = str_replace("'", "''", $value);
                $query = $this->operator($operator, $query,$column,$escaped_value);
            }
        }

        $query = str_replace('AND  and','AND',$query);
        if($query == "SELECT b.billingid,b.userid,b.AppointmentId,a.Pokok,b.InsertDT,b.UpdateDT FROM tblbilling b JOIN tblagenda a ON a.AppointmentId=b.AppointmentId ".$where." AND "){
            $query = "SELECT b.billingid,b.userid,b.AppointmentId,a.Pokok,b.InsertDT,b.UpdateDT FROM tblbilling b JOIN tblagenda a ON a.AppointmentId=b.AppointmentId";
        }

        // Apply sorting
        $sort = $request->sort;
        if (isset($sort)) {
            $sort = json_decode($sort);
            $query .= " ORDER BY";
            foreach ($sort as $s) {
                $query .= " $s->selector " . ($s->desc ? "DESC" : "ASC") . ",";
            }
            $query = rtrim($query, ",");
        }

        // Apply paging
        $skip = $request->skip;
        $take = $request->take;
        if (isset($skip) && isset($take)) {
            $query .= " OFFSET $skip ROWS FETCH NEXT $take ROWS ONLY";
        }
        // $row number = ROW_NUMBER() OVER (ORDER BY (SELECT NULL))
        // WHERE RowNum > $skip AND RowNum <= ($skip + $take)
        
        // Execute query
        $data = DB::select($query);
        // Get total count
        $totalCount = DB::select("SELECT COUNT(*) as aggregate FROM tblbilling b JOIN tblagenda a ON a.AppointmentId=b.AppointmentId")[0]->aggregate;

        return response()->json([
            'data' => $data,
            'totalCount' => $totalCount,
            'query' => $query,
        ]);
    }

    public function dataBillInsert(Request $request)
    {
        $AppointmentId = isset($request->values['AppointmentId'])?$request->values['AppointmentId']:'';
        $data = [
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'companyid' => session('UIDGlob')->companyid,
            'userid' => $request->userid,
            'InsertDT' => Carbon::now(('app.GMT')),
            'statusid' => 1,
            'AppointmentId' => $AppointmentId,
            'Pokok' => isset($request->values['Pokok'])?$request->values['Pokok']:'',
        ];
        $billingid = tblbilling::insertGetId($data);
        $Ntrans = new TransactionController;
        $tblagenda = tblagenda::find($AppointmentId);
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
        $Ntrans->nextTransaction($billingid,$request->userid,$Lastdate,session('UIDGlob')->companyid);
        return response()->json(['success' => true]);
    }
    
    public function dataBillUpdate(Request $request)
    {
        $values = $request->values;
        $values['UserUpdate'] = session('UIDGlob')->userid;
        $values['UpdateDT'] = Carbon::now(config('app.GMT'));
        $tblbilling = tblbilling::find($request->billingid);
        $tblbilling->update($values);
        $tbltrans = tbltrans::where('userid',$tblbilling->userid)
                            ->where('statusid',5)
                            ->where('billingid',$request->billingid)
                            ->get();
        $tbltrans->each(function ($item) use ($tblbilling) {
            $item->Pokok = $tblbilling->Pokok;
            $item->UserUpdate = session('UIDGlob')->userid;
            $item->UpdateDT = Carbon::now(config('app.GMT'));
            $item->save();
        });
        return response()->json(['success' => true]);
    }
    public function dataBillDelete(Request $request){
        $tblbilling = tblbilling::find($request->billingid);
        $tblbilling->update([
            'statusid' => 4,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);

        $tbltrans = tbltrans::where('userid',$tblbilling->userid)
                            ->where('statusid',5)
                            ->where('billingid',$request->billingid)
                            ->get();
        $tbltrans->each(function ($item) use ($tblbilling) {
            $item->statusid = $tblbilling->statusid;
            $item->UserUpdate = $tblbilling->UserUpdate;
            $item->UpdateDT = $tblbilling->UpdateDT;
            $item->save();
        });
        return true;
    }
}
