<?php

namespace App\Http\Controllers;

use App\Models\tblmasterproduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterproductController extends Controller
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
    public function dataviewmaster(Request $request)
    {
        $where = "WHERE tblmasterproduct.statusid<>4 AND tblmasterproduct.companyid='".session('UIDGlob')->companyid."'";
        // $join = "JOIN tblproducttype ON tblproducttype.producttypeid=tblmasterproduct.producttypeid ";
        $join = " ";
        // Set base query
        $query = "SELECT * FROM tblmasterproduct ".$join.$where." ";

        // Apply filtering
        $filter = json_decode($request->filter);
        if (isset($filter)) {
            $query = "SELECT * FROM tblmasterproduct ".$join.$where." AND ";
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
        if($query == "SELECT * FROM tblmasterproduct ".$where." AND "){
            $query = "SELECT * FROM tblmasterproduct";
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
        $totalCount = DB::select("SELECT COUNT(*) as aggregate FROM tblmasterproduct")[0]->aggregate;

        return response()->json([
            'data' => $data,
            'totalCount' => $totalCount,
            'query' => $query
        ]);
    }

    public function dataviewmasterInsert(Request $request)
    {
        $productcode = isset($request->values['productCode'])?$request->values['productCode']:'';
        if(tblmasterproduct::where('productCode',$productcode)->where('companyid',session('UIDGlob')->companyid)->first()){
            return 0;
        }
        $data = [
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
            'productCode' => isset($request->values['productCode'])?$request->values['productCode']:'',
            'companyid' => session('UIDGlob')->companyid,
            'statusid' => 1,
            'productName' => isset($request->values['productName'])?$request->values['productName']:'',
            'producttypeid' => isset($request->values['producttypeid'])?$request->values['producttypeid']:'',
        ];
        tblmasterproduct::create($data);
        return response()->json(['success' => true]);
    }

    public function dataviewmasterUpdate(Request $request)
    {
        $values = $request->values;
        $values['UserUpdate'] = session('UIDGlob')->userid;
        $values['UpdateDT'] = Carbon::now(config('app.GMT'));
        $builder = tblmasterproduct::where('productCode',$request->productCode)->where('companyid',session('UIDGlob')->companyid)->first();
        $builder->update($values);
        return response()->json(['success' => true]);
    }
    public function dataviewmasterDelete(Request $request){
        $builder = tblmasterproduct::where('productCode',$request->productCode)->where('companyid',session('UIDGlob')->companyid)->first();
        $builder->update([
            'statusid' => 4,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        return true;
    }

}
