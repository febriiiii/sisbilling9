<?php

namespace App\Http\Controllers;

use App\Models\tblchat;
use App\Models\tblchatd;
use App\Models\tblcomp;
use App\Models\tblkomentar;
use App\Models\tblpengumuman;
use App\Models\tbluser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class ChatController extends Controller
{
    public function updateDevice(Request $request)
    {
        try {
            tbluser::find(session('UIDGlob')->userid)->update(['tokenDevice' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function sendFcm($userTarget,$title,$body,$arrayDevice)
    {
        if($arrayDevice == false){
            $tokenDevice = tbluser::find($userTarget)->tokenDevice;
            if($tokenDevice == null){
                return false;
            }
        }
        $logoUrl = asset('icon192.png');
        $actionUrl = 'localhost:8080/m_billing'; // URL tujuan ketika notifikasi diklik

        $factory = (new Factory)->withServiceAccount([
            "type"=> "service_account",
            "project_id"=> "mbilling-772a2",
            "private_key_id"=> "6d0aafe27c129c30d85f918c9d077b311c494d03",
            "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCu2OvQ8PkW9Tef\nyPZoHCLAojxKKw8/SkJh66MmSiZa7h8Ly3Hob4C12AP7YOHz7nynVGqO7Ol8cpCE\nBQF90AhsVTphEDM1KppGU2iIqzsAMLB8ntn0y+jZydErwkL8aH3OLWj4hiM7wGE2\nXe/Z4URxH6RiWLKi8L2ta1VZhzmy7MexJPsJkiqrDrZD+tY9Y6AadQAQukvzJvxt\nmpa9N4YibWKvNGbOGo6GQoPTqSE0bLsuqRPCyqqco/AYKDH8EjRozrkwBLVMY3a4\nHu5xmrtJaW39DLeAyvSNQ6ATIaqFzgGWeuefv3pzVn5paQfB+eo3j2+/ohbIFmAd\nMsMzUkPZAgMBAAECggEAALj8roIhPjV/IgESKm3iI3wrXISCVvj4vo/BmDUQ8Z0p\nOGLPAqgog5F6bYjh6vo2sZIkff85W5somqPfp/RN/wHSKjHUMfMBX+shbZ338jRn\ntYTwvyizLc7XxByUxMphj+wGbBW31XWIoVFXKxLmgsL5kOUV2R0LStYJX50ytJkK\np7nhaBGfC8pY/+y+k8pBkwueVXDfpncQSECl0zCz2RvJkjuPmEtcNAMt+fStwbKI\ncpKmwSXyZts186pH7Md8hbFoIf+uD7e22ukhB0LgfVinFbtF/IIi9j15KBQnKH4x\nvYkl7LusPBw0Tf2RzkEsp7cjllbQ6KAJ4wrwfxrBBQKBgQDvap2luNNSlmJQWJwL\nBLL/dfcdw+HEM3et8KXBP6GvBLiQoCd05UMksUuwVR+uKBvlvdI5mPAItlq1Rb0Z\nQTpX71GFL6fK9K72OHeOkrDR8yh7IJNDE71C6qJgPtkgpVDYvLWCvlBsRHOZ7Cvr\nUbWKztWGJk1676pOPkkkAw3+TQKBgQC69VoTcAEiRAhTU1hFKdGx4/eACmSpE6Z4\nxPM/mPgmN23DP3XVRAu7JIRIJHUFnqNmPFX/1DhYpUso4u2KMCz4/bD5ZT+CzR5W\n+2RTKtp1AvGqniHqNjY5AYoMaPMzrlhcYaaGNzXnHcn5JWjIGzhoNXTFRxjsVc1E\n+Za9iMgZvQKBgQCvpaeNGsEnGR991NR+nO75zsECvGAZQq0uFpx038suDSefK3Bn\nKYAOHmjqMDly2whEj/P4v8Ryj96SmVx3d8xnETPco67VjpgCGkFUfzhsf5mWY7rG\nfmfe/Sctt04yzjY3HJOKHTgBhmLNbWB3X1XyRXaP2fAEHmryxm2AlyEgDQKBgBUO\nTu/DfI00Zk+kIlvfwtsrFpPYF9AnA2e0nsS54LDFK1qDCi1TtZKFIVTSrk9Mt5Br\nGTBv4UyyiQ14yVH37Qi54bWk3otHuLQJKhpnyCTHiRozJxSuuFqhPr/5DfLzHsaA\nxPV2wF5gL4Ac43kt/6NU6erSAA+V9kFfbse34PltAoGAG7e96lhS8t5Jcg5DUljP\nUb2DrpblU6Dfg3FFzaFnvTmRoaz+QrIpcTunUmnA32ijMcfqzWvlWHdkp0N6/gI2\niB5hCqZwgjQo1c3LK9bx7yBrYVKyELO0jXleVmLYMlY2L5nzRooo+VZJ0ZkOD7YC\npm/OrUZ7uH0Asv7Wioj8dmQ=\n-----END PRIVATE KEY-----\n",
            "client_email"=> "firebase-adminsdk-iuu0q@mbilling-772a2.iam.gserviceaccount.com",
            "client_id"=> "108256540397154288506",
            "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
            "token_uri"=> "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-iuu0q%40mbilling-772a2.iam.gserviceaccount.com",
            "universe_domain"=> "googleapis.com"
        ]);

        $messaging = $factory->createMessaging();
        
        $notification = Notification::create($title, $body);

        if ($arrayDevice != false) {
            foreach ($arrayDevice as $e) {
                $message = CloudMessage::withTarget('token', $e)
                    ->withNotification($notification);
                try {
                    $messaging->send($message);
                } catch (\Kreait\Firebase\Exception\MessagingException $e) {
                    return false;
                }
            }
        }else{
            $message = CloudMessage::withTarget('token', $tokenDevice)
                ->withNotification($notification);
            try {
                $messaging->send($message);
            } catch (\Kreait\Firebase\Exception\MessagingException $e) {
                return false;
            }
        }

        return 'Notification Sent Successfully!';
    }

    public function polling(Request $request){
        $this->notifpengumuman(session('UIDGlob')->userid,$request->pengumumanid);
        $tblpengumuman = tblpengumuman::find($request->pengumumanid);
        $arrayPolling = json_decode($tblpengumuman->polling);

        $keypoling = [];
        $idrmv = false;
        $countUser = 0;
        foreach ($arrayPolling as $p) {
            $splitkeyval = explode(";", $p);
            $keypoling[$splitkeyval[0]] = isset($splitkeyval[1])?$splitkeyval[1]:'';
        }

        foreach ($keypoling as $key => $val) {
            $arrayuser = json_decode($val, true); // Set the second argument to true to return an associative array

            if ($request->arraypolling == $key) {
                if (is_array($arrayuser)) {
                    if (!in_array(session('UIDGlob')->userid, $arrayuser)) {
                        $arrayuser[] = (int) session('UIDGlob')->userid;
                    }
                } else {
                    $arrayuser = [(int) session('UIDGlob')->userid];
                }
            } else {
                if (is_array($arrayuser)) {
                    if (in_array(session('UIDGlob')->userid, $arrayuser)) {
                        $idrmv = $request->pengumumanid.$key;
                        $arrayuser = array_diff($arrayuser, [session('UIDGlob')->userid]);
                    }
                }
            }
            if (is_array($arrayuser) && $arrayuser !== null) {
                $countUser = $countUser + count($arrayuser);
            }else{
                $countUser = $countUser + 0;
            }
            // Update the value in the $keypoling array
            $keypoling[$key] = $arrayuser;
        }
        $newPolling = [];
        foreach ($keypoling as $key => $val) {
            $newPolling[] = $key . ';' . (is_array($val) ? json_encode(array_values($val)) : "");
        }
        $tblpengumuman->update(['polling' => json_encode($newPolling)]);

        $controller = new Controller;
        $pusher = $controller->setupPUSHER();

        $data['type'] = "polling";
        $data['id'] = $request->id;
        $data['idrmv'] = $idrmv;
        $data['countUser'] = $countUser;
        $data['classmax'] = 'class'.$request->pengumumanid;
        $pusher->trigger('my-channel', 'my-event', $data);

        return true;
    }
    public function sendpengumuman(Request $request){
        $polling = isset($request->polling)? json_encode($request->polling) : '';
        $pengumumanid = tblpengumuman::insertGetId([
            'companyid' => $request->companyid,
            'judul' => $request->judul,
            'pengumuman' => str_replace("<table>", "<table class='table-hover table table-bordered'>", $request->pengumuman),
            'polling' => $polling,
            'statusid' => 1,
            'isPengumumanCompany' => isset($request->isPengumumanCompany)? 1 : 0,
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        $this->GlobalPush("notif",null);
        $tblpengumuman = tblpengumuman::select('tblpengumuman.*','tbluser.userid','tbluser.nama',DB::raw("CONCAT('" . asset('public/storage/') . "','/', tbluser.profileImg) AS profileImg"))
                                ->join('tbluser','tbluser.userid','=','tblpengumuman.UserInsert')
                                ->where('pengumumanid',$pengumumanid)->first();

        $controller = new Controller;
        $pusher = $controller->setupPUSHER();

        $data['data'] = $tblpengumuman;
        if($tblpengumuman->isPengumumanCompany == 1){
            $data['type'] = "pesancompany";
            $data['data']['companyname'] = tblcomp::find($tblpengumuman->companyid)->companyname;
            $data['data']['InsertDT'] = Carbon::parse($tblpengumuman->InsertDT)->format('Y-m-d H:i');
        }else{
            $data['type'] = "pengumumanforum";
        }
        $pusher->trigger('my-channel', 'my-event', $data);

        $arrayDevice = [];
        $strcompA = session('UIDGlob')->companyidArray.','.session('UIDGlob')->companyid;
        $strcompA = implode(',',array_filter(explode(',',$strcompA),'strlen'));
        // dd($strcompA);
        $query = "SELECT * FROM tbluser WHERE companyid IN (".$strcompA.") OR (
            SELECT COUNT(*) FROM (
                SELECT value FROM STRING_SPLIT('".$strcompA."', ',')
                INTERSECT
                SELECT value FROM STRING_SPLIT(tbluser.companyidArray, ',')
            ) AS matches
        ) > 0";
        $userArray = DB::select($query);
        foreach ($userArray as $e) {
            if($e->tokenDevice != '' || $e->tokenDevice != null){
                $arrayDevice[] = $e->tokenDevice;
            }
        }
        if(count($arrayDevice) != 0){
            $this->sendFcm(false,$tblpengumuman->nama." Mengirim Pengumuman",$tblpengumuman->judul,$arrayDevice);
        }
        return true;
    }
    
    public function GlobalPush($type,$target){
        $controller = new Controller;
        $pusher = $controller->setupPUSHER();
 
        $data['type'] = $type;
        $data['authuser'] = $target;
        $pusher->trigger('my-channel', 'my-event', $data);
        return true;
    }
    public function notifpengumuman($userid,$pengumumanid){
        $tblpengumuman = tblpengumuman::find($pengumumanid);
        $reader = in_array($userid, explode(',', $tblpengumuman->usersRead));
        $coma = ($tblpengumuman->usersRead == '')? '':',';
        $reader = $reader ? $tblpengumuman->usersRead : $tblpengumuman->usersRead.$coma.$userid;
        DB::update("UPDATE tblpengumuman SET usersRead = '".$reader."' WHERE pengumumanid = ".$pengumumanid);
        $this->GlobalPush("notif",null);
        return true;
    }
    public function readpengumuman(Request $request){
        $this->notifpengumuman($request->userid,$request->pengumumanid);
        return true;
    }
    public function replypengumuman(Request $request){
        $authUserid = session('UIDGlob')->userid;
        $this->notifpengumuman($authUserid,$request->pengumumanid);
        $tblpengumuman = tblpengumuman::find($request->pengumumanid);
        if($tblpengumuman->UserInsert == $authUserid){
            return -1;
        }

        $userArray = '['.$tblpengumuman->UserInsert.','.$authUserid.']';
        $userArray2 = '['.$authUserid.','.$tblpengumuman->UserInsert.']';
        $idchatTemp = tblchat::select('chatid')->where('userArray',$userArray)->orWhere('userArray',$userArray2)->first();
        $wrap = "<i style='font-size:0.8em;margin:0;padding:0;'>mengomentari:<br>".$tblpengumuman->pengumuman."</i><hr style='margin:0;padding:5px;'>";
        $descript = $wrap.htmlspecialchars($request->description, ENT_QUOTES, 'UTF-8');
        if(isset($idchatTemp)){
            $chatdID = tblchatd::insertGetId([
                'chatid' => $idchatTemp->chatid,
                'description' => $descript,
                'userid' => $authUserid,
                'statusid' => 1,
                'UserInsert' => $authUserid,
                'UserUpdate' => $authUserid,
                'InsertDT' => Carbon::now(config('app.GMT')),
                'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
            $chatid = $idchatTemp->chatid;
        }else{
            $tblchat = tblchat::insertGetId([
                    'companyid' => $tblpengumuman->companyid,
                    'userArray' => '['.$tblpengumuman->UserInsert.','.$authUserid.']',
                    'statusid' => 1,
                    'UserInsert' => $authUserid,
                    'UserUpdate' => $authUserid,
                    'InsertDT' => Carbon::now(config('app.GMT')),
                    'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
            $chatid = $tblchat;
            $chatdID = tblchatd::insertGetId([
                'chatid' => $tblchat,
                'description' => $descript,
                'userid' => $authUserid,
                'statusid' => 1,
                'UserInsert' => $authUserid,
                'UserUpdate' => $authUserid,
                'InsertDT' => Carbon::now(config('app.GMT')),
                'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
        }

        $this->pushnotifsendchat($chatdID,$chatid,$authUserid,session('UIDGlob')->nama,$descript);

        return $tblpengumuman->UserInsert;
    }
    public function getchatLawan(Request $request){
        $tblchat =  tblchat::select('chatid')->where('userArray','['.$request->userid.','.session('UIDGlob')->userid.']')
                ->orWhere('userArray','['.session('UIDGlob')->userid.','.$request->userid.']')->first();
        
        if(!isset($tblchat)){
            $chatid = tblchat::insertGetId([
                    'companyid' => 1,
                    'userArray' => '['.session('UIDGlob')->userid.','.$request->userid.']',
                    'statusid' => 1,
                    'UserInsert' => session('UIDGlob')->userid,
                    'UserUpdate' => session('UIDGlob')->userid,
                    'InsertDT' => Carbon::now(config('app.GMT')),
                    'UpdateDT' => Carbon::now(config('app.GMT')),
            ]);
            return $chatid;
        }
        return $tblchat->chatid;
    }
    public function getchatid(Request $request){
        $userArray = '['.$request->userid.','.session('UIDGlob')->userid.']';
        $userArray2 = '['.session('UIDGlob')->userid.','.$request->userid.']';
        if($request->userid == session('UIDGlob')->userid){
            return 0;
        }
        return tblchat::select('chatid')->where('userArray',$userArray)->orWhere('userArray',$userArray2)->first();
    }
    public function getchatd(Request $request){
        $userArray = json_decode(tblchat::find($request->chatid)->userArray);
        foreach ($userArray as $u) {
            if($u != session('UIDGlob')->userid){
                $data['header'] = tbluser::select('nama','profileImg')->where('userid',$u)->first();
            }
        }
        $data['detail'] = tblchatd::select(DB::raw('tblchatd.*,nama,  CONVERT(VARCHAR(5), tblchatd.InsertDT, 108) AS timef,' . session('UIDGlob')->userid . ' AS userauth'))
        ->join('tbluser','tbluser.userid','=','tblchatd.userid')
        ->where('tblchatd.statusid','!=',4)
        ->where('chatid',$request->chatid)->get();
        DB::update("UPDATE tblchatd SET statusid = 9 WHERE chatid = ".$request->chatid);
        return $data;
    }
    public function readchat(Request $request){
        DB::update("UPDATE tblchatd SET statusid = 9 WHERE chatid = ".$request->chatid);
        return 1;
    }
    public function getkomentard(Request $request){
        $data = tblkomentar::select(DB::raw('tblkomentar.*,nama,profileImg'))
        ->join('tbluser','tbluser.userid','=','tblkomentar.userid')
        ->where('tblkomentar.statusid','!=',4)
        ->where('tblkomentar.pengumumanid',$request->pengumumanid)->get();
        DB::update("UPDATE tblkomentar SET statusid = 9 WHERE pengumumanid = ".$request->pengumumanid);
        return $data;
    }
    public function sendchat(Request $request)
    {
        $authUserid = session('UIDGlob')->userid;
        $chatdID = tblchatd::insertGetId([
            'chatid' => $request->chatid,
            'description' => $request->description,
            'userid' => $authUserid,
            'statusid' => 1,
            'UserInsert' => $authUserid,
            'UserUpdate' => $authUserid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        $this->pushnotifsendchat($chatdID,$request->chatid,$authUserid,session('UIDGlob')->nama,$request->description);

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function sendkomentar(Request $request)
    {
        $tblchatd = tblkomentar::create([
            'pengumumanid' => $request->pengumumanid,
            'pesan' => $request->description,
            'userid' => session('UIDGlob')->userid,
            'statusid' => 1,
            'UserInsert' => session('UIDGlob')->userid,
            'UserUpdate' => session('UIDGlob')->userid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);

        $controller = new Controller;
        $pusher = $controller->setupPUSHER();

        $userTarget = tblpengumuman::find($request->pengumumanid)->UserInsert;
        $data['type'] = "komentarcompany";
        $data['pesan'] = $request->description;
        $data['pengumumanid'] = $request->pengumumanid;
        $data['nama'] = session('UIDGlob')->nama;
        $data['profileImg'] = session('UIDGlob')->profileImg;
        $data['InsertDT'] = $tblchatd->InsertDT;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->sendFcm($userTarget,session('UIDGlob')->nama .'Mengomentari Pengumuman Anda',$request->description,false);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function sendimgchat(Request $request){
        $log = new Controller;
        $log->savelog(json_encode($_FILES));
        $authUserid = session('UIDGlob')->userid;
        $chatdID = tblchatd::insertGetId([
            'chatid' => $request->chatid,
            'description' => "!@##@!IMG!@##@!",
            'userid' => $authUserid,
            'statusid' => 1,
            'UserInsert' => $authUserid,
            'UserUpdate' => $authUserid,
            'InsertDT' => Carbon::now(config('app.GMT')),
            'UpdateDT' => Carbon::now(config('app.GMT')),
        ]);
        
        $file = $request->file('image');
        // $exten = $file->getClientOriginalExtension();
        $path = $file->storeAs('public/chatimg', $chatdID.".png");
        
        Storage::url($path);
        $path = asset('public/storage/'.'chatimg/'.$chatdID.".png");
        
        $this->pushnotifsendchat($chatdID,$request->chatid,$authUserid,session('UIDGlob')->nama,"!@##@!IMG!@##@!");
        
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function pushnotifsendchat($chatdID,$chatid,$authUserid,$authNama,$desc){
        $controller = new Controller;
        $pusher = $controller->setupPUSHER();

        $userArray = json_decode(tblchat::find($chatid)->userArray);
        ($userArray[1] == $authUserid)?$userTarget = $userArray[0]:$userTarget = $userArray[1];
        $data['type'] = "chat";
        $data['id'] = $chatdID;
        $data['description'] = $desc;
        $data['chatid'] = $chatid;
        $data['authuser'] = $authUserid;
        $data['nama'] = $authNama;
        $data['InsertDT'] = Carbon::now(config('app.GMT'))->format('H:i');
        $pusher->trigger('my-channel', 'my-event', $data);
        if($desc == "!@##@!IMG!@##@!"){
            $desc = "Mengirim Gambar";
        }
        $this->sendFcm($userTarget,$authNama,$desc,false);
        
        $this->GlobalPush("notif",$authUserid);
        return true;
    }
}
