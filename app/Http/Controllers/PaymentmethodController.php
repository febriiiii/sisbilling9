<?php

namespace App\Http\Controllers;

use App\Models\tblpaymentmethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentmethodController extends Controller
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
    public function dataviewpaymentmethod(Request $request)
    {
        $where = "WHERE tblpaymentmethod.statusid<>4 AND companyid IN (1,".session('UIDGlob')->companyid.")";
        $join = " ";
        // Set base query
        $query = "SELECT * FROM tblpaymentmethod ".$join.$where." ";

        // Apply filtering
        $filter = json_decode($request->filter);
        if (isset($filter)) {
            $query = "SELECT * FROM tblpaymentmethod ".$join.$where." AND ";
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
        if($query == "SELECT * FROM tblpaymentmethod ".$where." AND "){
            $query = "SELECT * FROM tblpaymentmethod";
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
        $totalCount = DB::select("SELECT COUNT(*) as aggregate FROM tblpaymentmethod")[0]->aggregate;

        return response()->json([
            'data' => $data,
            'totalCount' => $totalCount,
            'query' => $query
        ]);
    }

    public function dataviewpaymentmethodInsert(Request $request)
    {
        $data = [
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
            'companyid' => session('UIDGlob')->companyid,
            'statusid' => 1,
            'paymentName' => isset($request->values['paymentName'])?$request->values['paymentName']:'',
            'RekTujuan' => isset($request->values['RekTujuan'])?$request->values['RekTujuan']:'',
            'AtasNama' => isset($request->values['AtasNama'])?$request->values['AtasNama']:'',
        ];
        tblpaymentmethod::create($data);
        return response()->json(['success' => true]);
    }

    public function dataviewpaymentmethodUpdate(Request $request)
    {
        $values = $request->values;
        $values['UserUpdate'] = session('UIDGlob')->userid;
        $values['UpdateDT'] = Carbon::now(config('app.GMT'));
        $builder = tblpaymentmethod::find($request->paymentid);
        $builder->update($values);
        return response()->json(['success' => true]);
    }
    public function dataviewpaymentmethodDelete(Request $request){
        $builder = tblpaymentmethod::find($request->paymentid);
        if($builder->paymentid != 1){
            $builder->update([
                'statusid' => 4,
                'UserUpdate' => session('UIDGlob')->userid,
                'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
        }
        return true;
    }
}
