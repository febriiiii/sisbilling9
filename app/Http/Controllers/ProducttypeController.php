<?php

namespace App\Http\Controllers;

use App\Models\tblproducttype;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProducttypeController extends Controller
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
    public function dataviewproducttype(Request $request)
    {
        $where = "WHERE tblproducttype.statusid<>4 AND tblproducttype.companyid='".session('UIDGlob')->companyid."'";
        $join = " ";
        // Set base query
        $query = "SELECT * FROM tblproducttype ".$join.$where." ";

        // Apply filtering
        $filter = json_decode($request->filter);
        if (isset($filter)) {
            $query = "SELECT * FROM tblproducttype ".$join.$where." AND ";
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
        if($query == "SELECT * FROM tblproducttype ".$where." AND "){
            $query = "SELECT * FROM tblproducttype";
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
        $totalCount = DB::select("SELECT COUNT(*) as aggregate FROM tblproducttype")[0]->aggregate;

        return response()->json([
            'data' => $data,
            'totalCount' => $totalCount,
            'query' => $query
        ]);
    }

    public function dataviewproducttypeInsert(Request $request)
    {
        $data = [
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
            'companyid' => session('UIDGlob')->companyid,
            'statusid' => 1,
            'productTypeName' => isset($request->values['productTypeName'])?$request->values['productTypeName']:'',
        ];
        tblproducttype::create($data);
        return response()->json(['success' => true]);
    }

    public function dataviewproducttypeUpdate(Request $request)
    {
        $values = $request->values;
        $values['UserUpdate'] = session('UIDGlob')->userid;
        $values['UpdateDT'] = Carbon::now(config('app.GMT'));
        $builder = tblproducttype::find($request->producttypeid);
        $builder->update($values);
        return response()->json(['success' => true]);
    }
    public function dataviewproducttypeDelete(Request $request){
        $builder = tblproducttype::find($request->producttypeid);
        $builder->update([
            'statusid' => 4,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        return true;
    }
}
