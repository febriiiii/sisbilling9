<?php

namespace App\Http\Controllers;

use App\Models\tbluser;
use Carbon\Carbon;
use Hamcrest\Type\IsString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MycustomerController extends Controller
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
    public function dataMycustomer(Request $request)
    {
        $where = "WHERE companyidArray LIKE '%".session('UIDGlob')->companyid.",%' AND statusid<>4";

        // Set base query
        $query = "SELECT userid,nama,hp,alamatSingkat,alamatLengkap,infoTambahan,email,InsertDT,UpdateDT FROM tbluser ".$where." ";

        // Apply filtering
        $filter = json_decode($request->filter);
        if (isset($filter)) {
            $query = "SELECT userid,nama,hp,alamatSingkat,alamatLengkap,infoTambahan,email,InsertDT,UpdateDT FROM tbluser ".$where." AND ";
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
        if($query == "SELECT userid,nama,hp,alamatSingkat,alamatLengkap,infoTambahan,email,InsertDT,UpdateDT FROM tbluser ".$where." AND "){
            $query = "SELECT userid,nama,hp,alamatSingkat,alamatLengkap,infoTambahan,email,InsertDT,UpdateDT FROM tbluser";
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
        $totalCount = DB::select("SELECT COUNT(*) as aggregate FROM tbluser")[0]->aggregate;

        return response()->json([
            'data' => $data,
            'totalCount' => $totalCount,
            'query' => $query
        ]);
    }

    public function dataMycustomerInsert(Request $request)
    {
        $data = [
            'companyidArray' => session('UIDGlob')->companyid.",",
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'profileImg' => 'user/user.png',
            'UpdateDT' => Carbon::now(config('app.GMT')),
            'userid' => session('UIDGlob')->userid,
            'statusid' => 1,
            'nama' => isset($request->values['nama'])?$request->values['nama']:'',
            'hp' => isset($request->values['hp'])?$request->values['hp']:'',
            'email' => isset($request->values['email'])?$request->values['email']:'',
            'password' => Hash::make(isset($request->values['email'])?$request->values['email']:''),
            'alamatSingkat' => isset($request->values['alamatSingkat'])? $request->values['alamatSingkat'] : '',
            'alamatLengkap' => isset($request->values['alamatLengkap'])?$request->values['alamatLengkap']:'',
            'infoTambahan' => isset($request->values['infoTambahan'])?$request->values['infoTambahan']:'',
            'pilihPengelola' => session('UIDGlob')->pilihPengelola,
        ];
        tbluser::create($data);
        return response()->json(['success' => true]);
    }

    public function dataMycustomerUpdate(Request $request)
    {
        $values = $request->values;
        $values['UserUpdate'] = session('UIDGlob')->userid;
        $values['UpdateDT'] = Carbon::now(config('app.GMT'));
        $builder = tbluser::find($request->userid);
        $builder->update($values);
        return response()->json(['success' => true]);
    }
    public function dataMycustomerDelete(Request $request){
        $builder = tbluser::find($request->userid);
        $builder->update([
            'statusid' => 4,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        return true;
    }
}
