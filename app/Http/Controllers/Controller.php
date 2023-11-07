<?php

namespace App\Http\Controllers;

use App\Models\tblchatd;
use App\Models\tblcomp;
use App\Models\tblmasterproduct;
use App\Models\tblnotif;
use App\Models\tblpengumuman;
use App\Models\tblproducttype;
use App\Models\tbluser;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Pusher\Pusher;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        session(['UIDGlob' => tbluser::find(auth()->user()->userid)]);

        $controller = new Controller;
        $tblproducttype = tblproducttype::where('statusid','!=',4)->where('companyid',1)->get();
        $tblcomp = tblcomp::where('companyid',session('UIDGlob')->companyid)->first();
        $tblcomp = [
            'companyid' => isset($tblcomp->companyid)? $tblcomp->companyid : '',
            'companyname' => isset($tblcomp->companyname)? $tblcomp->companyname : '',
            'productTypeName' => isset($tblcomp->productTypeName)? $tblcomp->productTypeName : '',
            'email' => isset($tblcomp->email)? $tblcomp->email : '',
            'hp' => isset($tblcomp->hp)? $tblcomp->hp : '',
            'companyaddress' => isset($tblcomp->companyaddress)? $tblcomp->companyaddress : '',
            'producttypeArray' => isset($tblcomp->producttypeArray)? $tblcomp->producttypeArray : '',
            'Server_Key' => isset($tblcomp->Server_Key)? $this->decrypt($tblcomp->Server_Key) : 'Hub CS Sisbilling untuk Mengisi ini',
            'Client_Key' => isset($tblcomp->Client_Key)? $this->decrypt($tblcomp->Client_Key) : 'Hub CS Sisbilling untuk Mengisi ini',
            'Merchant_ID' => isset($tblcomp->Merchant_ID)? $this->decrypt($tblcomp->Merchant_ID) : 'Hub CS Sisbilling untuk Mengisi ini',
        ];
        
        $cid = $this->inCidSelf();
        $useridQ = session('UIDGlob')->userid;
        $dateExpression = Carbon::now(config("app.GMT"))->subMonth(1)->format('Y-m-d H:i:s');
        $query = "SELECT p.*, c.companyname, u.userid, u.nama, u.profileImg, CASE WHEN u.companyid IS NULL THEN 0 ELSE 1 END AS ispengelola 
                FROM tblpengumuman p
                JOIN tbluser u ON u.userid = p.UserInsert
                JOIN tblcomp c ON c.companyid = p.companyid
                WHERE p.statusid <> 4 
                    AND p.UserInsert = '{$useridQ}'
                    AND p.InsertDT > '{$dateExpression}'
                UNION
                SELECT p.*, c.companyname, u.userid, u.nama, u.profileImg, CASE WHEN u.companyid IS NULL THEN 0 ELSE 1 END AS ispengelola 
                FROM tblpengumuman p
                JOIN tbluser u ON u.userid = p.UserInsert
                JOIN tblcomp c ON c.companyid = p.companyid
                WHERE p.statusid <> 4 
                    AND p.companyid IN ({$cid}) AND p.companyid <> 1
                    AND p.InsertDT > '{$dateExpression}'
                ORDER BY InsertDT DESC";
        $tblpengumuman = DB::select($query);
        // $countchat = DB::select("SELECT * FROM tblchat WHERE PATINDEX('%[".session('UIDGlob')->userid."]%', userArray) > 0");
        session('UIDGlob')->scrb = count(DB::select("SELECT top 1 t.AppointmentId
                                FROM tbltrans t
                                JOIN tblstatus s ON t.statusid=s.statusid
                                JOIN tbluser u ON u.userid=t.userid
                                JOIN tblagenda a ON a.AppointmentId=t.AppointmentId
                                JOIN tblmasterproduct p ON p.productCode=a.productCode
                                WHERE (t.statusid IN (7) OR (t.SPokok + t.SBunga + t.SLateFee < 1 AND t.statusid IN (5)))
                                AND p.isSubscribe = 1 AND t.userid={$useridQ}"));
        $paket = tblmasterproduct::where('isSubscribe',1)->where('price','>',1)->get();
        $kataKataPromosi = array(
            "Langganan Sekarang, Hemat Waktu dan Tenaga.",
            "Manajemen Tagihan Lebih Mudah dengan Berlangganan.",
            "Diskon Spesial 20% untuk Pelanggan Berlangganan.",
            "Coba Berlangganan Gratis Selama 30 Hari.",
            "Dapatkan Akses Premium dengan Berlangganan Bulanan.",
            "Sistem Penagihan Otomatis dengan Berlangganan.",
            "Tidak Perlu Repot, Langganan Sekarang!",
            "Pantau Tagihan Anda dengan Mudah.",
            "Hemat Biaya dengan discount, Ayo Berlangganan.",
            "Bergabung dengan Ribuan Pelanggan yang Telah Berlangganan.",
            "Penagihan Tanpa Khawatir dengan Berlangganan SisBilling.",
            "Lacak Tagihan Anda dengan Aplikasi Tagihan Terbaik Kami.",
            "Penagihan Cepat dan Tepat dengan SisBilling.",
            "Langganan Sekarang dan Nikmati Manfaatnya!"
        );
        foreach ($paket as $pkt) {
            $indeksAcak = array_rand($kataKataPromosi);
            $pkt->kataPromo = $kataKataPromosi[$indeksAcak];
        }
        return view('layout/main',compact('tblproducttype','cid','tblcomp','tblpengumuman','paket'));
    }
    public function inCidSelf(){
        $arr = explode(',', session('UIDGlob')->companyidArray);
        array_pop($arr);
        if(session('UIDGlob')->companyid == null){
            return "'" . implode("','", $arr) . "'";
        }else{
            return "'" . implode("','", $arr) . "'".",'".session('UIDGlob')->companyid."'";
        }
    }
    public function inCidNotSelf(){
        $arr = explode(',', session('UIDGlob')->companyidArray);
        array_pop($arr);
        return "'" . implode("','", $arr) . "'";
    }

    public function login(){
        $eod = new TransactionController;
        $eod->eod();
        return view('displayLogin');
    }
    public function auuten(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $tbluser = tbluser::where('email',$credentials['email'])->first();
        
        if(isset($tbluser->statusid)){
            if($tbluser->statusid == 4){
                goto Out;
            }
            if($tbluser->isAktif == 0){
                return back()->withErrors([
                    'email' => 'Akun Anda Telah Habis Masa Aktif, Tolong Hubungi CS SisBilling',
                ])->onlyInput('email');
            }
        }
        if (Auth::attempt($credentials)) {
            session_start();
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        Out:
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        request()->session()->flush();
        return redirect('/login');
    }

    function savelog($string){
        $file_path = storage_path('SaveLog.xls');
        if (!file_exists($file_path)) {
            $file = fopen($file_path, "w");
            fclose($file);
        }
        $file = fopen($file_path, "a");
        fwrite($file ,$string. "\n");
        fclose($file);
    }

    public function setupPUSHER(){
        $options = array(
            'cluster' => config('app.PUSHER_APP_CLUSTER'),
            'useTLS' => true
        );
 
        $pusher = new Pusher(
            config('app.PUSHER_APP_KEY'),
            config('app.PUSHER_APP_SECRET'),
            config('app.PUSHER_APP_ID'),
            $options
        );
        return $pusher;
    }

    public function PAT($string){
        $PAT = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $PAT .= '['.$string[$i].']';
        }
        return $PAT . '[,]';
    }

    public function grid($selected,$from,$join,$where,$request){
        // Set base query
        $query = "SELECT ".$selected." FROM ".$from." ".$join." ".$where." ";

        // Apply filtering
        $filter = json_decode($request->filter);
        if (isset($filter)) {
            $query = "SELECT ".$selected." FROM ".$from." ".$join." ".$where." AND ";
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
        if($query == "SELECT ".$selected." FROM ".$from." ".$where." AND "){
            $query = "SELECT ".$selected." FROM ".$from."";
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
        }else{
            // Jika tidak ada pengurutan, gunakan (SELECT 0) agar tidak error
            $query .= " ORDER BY (SELECT 0)";
        }

        // Apply paging
        $skip = $request->skip;
        $take = $request->take;
        if (isset($skip) && isset($take)) {
            $query .= " OFFSET $skip ROWS FETCH NEXT $take ROWS ONLY";
        }
        // SELECT * FROM tbluser
        // ORDER BY userid 
        // OFFSET 0 ROWS
        // FETCH NEXT 6 ROWS ONLY

        // Execute query
        $data = DB::select($query);

        // Get total count
        $totalCount = DB::select("SELECT COUNT(*) as aggregate FROM ".$from."")[0]->aggregate;

        return response()->json([
            'data' => $data,
            'totalCount' => $totalCount,
            'query' => $query
        ]);
    }
    public function getNoTrans($companyid){
        // note: jika lastdate tidak ada maka tidak ada recuren
        $tblcomp = tblcomp::find($companyid);
        $notransHeader = $companyid.strtoupper(substr($tblcomp->companyname, 0, 2)).Carbon::now(config('app.GMT'))->format('ymd');
        $lastTrans = DB::select("SELECT ISNULL(MAX(CAST(SUBSTRING(notrans, LEN('$notransHeader') + 1, LEN(notrans)) AS INT)) + 1, 1) AS maxNotrans
                                    FROM tbltrans
                                    WHERE notrans LIKE '".$notransHeader."%'");

        $notrans = $notransHeader.sprintf("%05d", $lastTrans[0]->maxNotrans);
        $TransactionController = new TransactionController;
        while ($TransactionController->cekstatusMID($notrans,$companyid)->status_code != 404) {
            if($TransactionController->cekstatusMID($notrans,$companyid)->status_code == 401){
                dd(
                    $TransactionController->cekstatusMID($notrans,$companyid), 
                    config('app.serverKey'), 
                    "base64_encode : " . base64_encode(config('app.serverKey').':'), 
                    config('app.URLmidv2'),
                    "isProduction : ".config('app.isProduction')
                ); // Stop Looping
            }
            $notrans = intval(substr($notrans, strlen($notransHeader))); // Mengambil angka dari nomor transaksi
            $notrans++; // Increment nomor transaksi jika sudah dipakai di MIDTRANS
            $notrans = $notransHeader.sprintf("%05d", $notrans); // Menggabungkan kembali nomor transaksi yang telah di-increment
        }
        return $notrans;
    }

    public function notifInsert($userid,$desc,$uniqCode){
        $chatcontroller = new ChatController;
        $now = Carbon::now(config('app.GMT'));
        tblnotif::create([
            'userid' => $userid,
            'deskripsi' => $desc,
            'uniqCode' => $uniqCode,
            'statusid' => 1,
            'UserInsert' => session('UIDGlob')->userid,
            'InsertDT' => $now,
            'UserUpdate' => session('UIDGlob')->userid,
            'UpdateDT' => $now,
        ]);
        $chatcontroller->GlobalPush("notif",$userid);
        return true;
    }
    public function notifUpdate($userid,$desc,$uniqCode){
        $chatcontroller = new ChatController;
        $now = Carbon::now(config('app.GMT'));
        $ntf = tblnotif::where('uniqCode',$uniqCode)->where('statusid','!=',4)->first();
        if(isset($ntf)){
            $ntf->update([
                'deskripsi' => $desc,
                'statusid' => 1,
                'UserUpdate' => session('UIDGlob')->userid,
                'UpdateDT' => $now,
            ]);
        }
        $chatcontroller->GlobalPush("notif",$userid);
        return true;
    }
    public function encrypt($text) {
        $iv = random_bytes(16); // Generate initial vector
        $cipherText = openssl_encrypt($text, 'AES-256-CFB', "as4s%2s&7", 0, $iv);
        return base64_encode($iv . $cipherText); // Encode IV + ciphertext as base64
    }
    
    public function decrypt($text) {
        $data = base64_decode($text);
        $iv = substr($data, 0, 16); // Extract IV
        $cipherText = substr($data, 16);
        return openssl_decrypt($cipherText, 'AES-256-CFB', "as4s%2s&7", 0, $iv);
    }
    public function MIDConf($trans,$companyid){
        $comp = tblcomp::find($companyid);
        $conf['serverKey'] = $this->decrypt($comp->Server_Key);
        $conf['isProduction'] = config('app.isProduction');
        $conf['isSanitized'] = config('app.isSanitized');
        $conf['is3ds'] = config('app.is3ds');
        return new CreateSnapTokenService($trans,$conf);
    }
}
