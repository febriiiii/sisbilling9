<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MasterproductController;
use App\Http\Controllers\MycustomerController;
use App\Http\Controllers\PaymentmethodController;
use App\Http\Controllers\ProducttypeController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewtabController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::put('/dd', function (Request $request) {
    
    return true;
});
Route::get('/otpC', function () {
    $data = [
        'name' => 'febri risnandi',
        'otp' => '123456'
    ];
    return view('otp', $data);
});
// MAIL
Route::get('/aprovalfile', [MailController::class, 'aprovalfile'])->name('aprovalfile');


// FCM 
Route::patch('/fcm-token', [ChatController::class, 'updateToken'])->name('fcmToken');
Route::get('/sendFcm',[ChatController::class,'sendFcm'])->name('sendFcm');
Route::post('/updateDevice',[ChatController::class,'updateDevice'])->name('updateDevice');

Route::get('nextAppointment', [TransactionController::class, 'nextAppointment'])->middleware('auth');

Route::get('', [Controller::class, 'index'])->middleware('no-cache', 'auth');
Route::get('/home', [Controller::class, 'index'])->middleware('no-cache','auth')->name('home');
Route::get('/login', [Controller::class, 'login'])->name('login')->middleware('no-cache', 'guest');
Route::post('/auuten', [Controller::class, 'auuten']);
Route::get('/logout', [Controller::class, 'logout'])->name('logout');

Route::get('/usertocomp', [UserController::class, 'usertocomp']);
Route::get('/companytouser', [UserController::class, 'companytouser']);
Route::get('/registerView', [UserController::class, 'registerView'])->middleware('guest');
Route::get('/forgot', [UserController::class, 'forgot'])->middleware('guest');
Route::post('/register', [UserController::class, 'register']);
Route::post('/otp', [UserController::class, 'otp']);
Route::get('/otpSET', [UserController::class, 'otpSET']);
Route::post('/confirmotp', [UserController::class, 'confirmotp']);
Route::post('/uploadimageprofile', [UserController::class, 'uploadimageprofile'])->middleware('auth');
Route::post('/updateUser', [UserController::class, 'updateUser'])->middleware('auth');
Route::post('/changePass', [UserController::class, 'changePass'])->middleware('auth');
Route::get('/updateTutor', [UserController::class, 'updateTutor'])->middleware('auth');

Route::get('/getcomp', [QueryController::class, 'tblcomp'])->middleware('auth');
Route::get('/producttype', [QueryController::class, 'tblproducttype'])->middleware('auth');
Route::get('/masterproduct', [QueryController::class, 'tblmasterproduct'])->middleware('auth');
Route::get('/appoinmentbill', [QueryController::class, 'appoinmentbill'])->middleware('auth');
Route::get('/appoinmentbillInfo', [QueryController::class, 'appoinmentbillInfo'])->middleware('auth');
Route::get('/chatHeader', [QueryController::class, 'chatHeader'])->middleware('auth');

Route::get('/dataBill', [BillController::class, 'dataBill'])->middleware('auth');
Route::post('/dataBillInsert', [BillController::class, 'dataBillInsert'])->middleware('auth');
Route::post('/dataBillUpdate', [BillController::class, 'dataBillUpdate'])->middleware('auth');
Route::post('/dataBillDelete', [BillController::class, 'dataBillDelete'])->middleware('auth');

Route::get('/dataMycustomer', [MycustomerController::class, 'dataMycustomer']);
Route::post('/dataMycustomerInsert', [MycustomerController::class, 'dataMycustomerInsert'])->middleware('auth');
Route::post('/dataMycustomerUpdate', [MycustomerController::class, 'dataMycustomerUpdate'])->middleware('auth');
Route::post('/dataMycustomerDelete', [MycustomerController::class, 'dataMycustomerDelete'])->middleware('auth');

Route::get('/dataviewmaster', [MasterproductController::class, 'dataviewmaster'])->middleware('auth');
Route::post('/dataviewmasterInsert', [MasterproductController::class, 'dataviewmasterInsert'])->middleware('auth');
Route::post('/dataviewmasterUpdate', [MasterproductController::class, 'dataviewmasterUpdate'])->middleware('auth');
Route::post('/dataviewmasterDelete', [MasterproductController::class, 'dataviewmasterDelete'])->middleware('auth');

Route::get('/dataviewproducttype', [ProducttypeController::class, 'dataviewproducttype'])->middleware('auth');
Route::post('/dataviewproducttypeInsert', [ProducttypeController::class, 'dataviewproducttypeInsert'])->middleware('auth');
Route::post('/dataviewproducttypeUpdate', [ProducttypeController::class, 'dataviewproducttypeUpdate'])->middleware('auth');
Route::post('/dataviewproducttypeDelete', [ProducttypeController::class, 'dataviewproducttypeDelete'])->middleware('auth');

Route::get('/dataviewpaymentmethod', [PaymentmethodController::class, 'dataviewpaymentmethod'])->middleware('auth');
Route::post('/dataviewpaymentmethodInsert', [PaymentmethodController::class, 'dataviewpaymentmethodInsert'])->middleware('auth');
Route::post('/dataviewpaymentmethodUpdate', [PaymentmethodController::class, 'dataviewpaymentmethodUpdate'])->middleware('auth');
Route::post('/dataviewpaymentmethodDelete', [PaymentmethodController::class, 'dataviewpaymentmethodDelete'])->middleware('auth');

Route::post('/companyUpdate', [CompanyController::class, 'companyUpdate'])->middleware('auth');

Route::get('/Getnavbar', [ViewtabController::class, 'Getnavbar'])->middleware('auth');
Route::get('/viewpivotmybilling', [ViewtabController::class, 'viewpivotmybilling'])->middleware('auth');
Route::get('/selectComp', [ViewtabController::class, 'selectComp'])->middleware('auth');
Route::get('/viewaddpesanforum', [ViewtabController::class, 'viewaddpesanforum'])->middleware('auth');
Route::get('/viewaddcustomer', [ViewtabController::class, 'viewaddcustomer'])->middleware('auth');
Route::get('/viewaddpengelola', [ViewtabController::class, 'viewaddpengelola'])->middleware('auth');
Route::get('/viewformbilling', [ViewtabController::class, 'viewformbilling'])->middleware('auth');
Route::get('/viewformagenda', [ViewtabController::class, 'viewformagenda'])->middleware('auth');
Route::get('/viewpayment', [ViewtabController::class, 'viewpayment'])->middleware('auth');
Route::get('/viewhome', [ViewtabController::class, 'viewhome'])->middleware('auth');
Route::get('/viewmasterproduct', [ViewtabController::class, 'viewmasterproduct'])->middleware('auth');
Route::get('/viewproductype', [ViewtabController::class, 'viewproductype'])->middleware('auth');
Route::get('/viewpaymentmethod', [ViewtabController::class, 'viewpaymentmethod'])->middleware('auth');
Route::get('/viewHeaderchat', [ViewtabController::class, 'viewHeaderchat'])->middleware('auth');
Route::get('/viewchat', [ViewtabController::class, 'viewchat'])->middleware('auth');
Route::get('/viewpolling', [ViewtabController::class, 'viewpolling'])->middleware('auth');
Route::get('/viewkomentarpengumuman', [ViewtabController::class, 'viewkomentarpengumuman'])->middleware('auth');
Route::get('/viewlonceng', [ViewtabController::class, 'viewlonceng'])->middleware('auth');
Route::get('/pusher', [ViewtabController::class, 'pusher'])->middleware('auth');
// administrator------------------------------------------------------------------------------------
Route::get('/adminindex', [ViewtabController::class, 'adminindex'])->middleware('auth');
Route::get('/modalbill', [ViewtabController::class, 'modalbill'])->middleware('auth');

Route::get('/readpengumuman', [ChatController::class, 'readpengumuman'])->middleware('auth');
Route::get('/getchatLawan', [ChatController::class, 'getchatLawan'])->middleware('auth');
Route::get('/getchatid', [ChatController::class, 'getchatid'])->middleware('auth');
Route::get('/polling', [ChatController::class, 'polling'])->middleware('auth');
Route::post('/sendpengumuman', [ChatController::class, 'sendpengumuman'])->middleware('auth');
Route::post('/replypengumuman', [ChatController::class, 'replypengumuman'])->middleware('auth');
Route::post('/getchatd', [ChatController::class, 'getchatd'])->middleware('auth');
Route::get('/readchat', [ChatController::class, 'readchat'])->middleware('auth');
Route::post('/sendchat', [ChatController::class, 'sendchat'])->middleware('auth');
Route::post('/getkomentard', [ChatController::class, 'getkomentard'])->middleware('auth');
Route::post('/sendkomentar', [ChatController::class, 'sendkomentar'])->middleware('auth');
Route::post('/chat', [ChatController::class, 'sendMessage'])->middleware('auth');
Route::post('/sendimgchat', [ChatController::class, 'sendimgchat'])->middleware('auth');

Route::get('/getPokok', [AgendaController::class, 'getPokok']);
Route::get('/dataStatus', [AgendaController::class, 'dataStatus']);
Route::get('/getAgenda', [AgendaController::class, 'getAgenda']);
Route::get('/getproduct', [AgendaController::class, 'getproduct']);
Route::put('/putUserPinjam', [AgendaController::class, 'putUserPinjam']);
Route::put('/putAgendaPinjam', [AgendaController::class, 'putAgendaPinjam']);
Route::post('/updateagendabill', [AgendaController::class, 'updateagendabill']);
Route::get('/getUserPinjam', [AgendaController::class, 'getUserPinjam']);
Route::get('/getAgendaPinjam', [AgendaController::class, 'getAgendaPinjam']);
Route::post('/insertAgenda', [AgendaController::class, 'insertAgenda'])->middleware('auth');
Route::put('/putAgenda', [AgendaController::class, 'putAgenda'])->middleware('auth');
Route::delete('/deleteAgenda', [AgendaController::class, 'deleteAgenda'])->middleware('auth');
Route::get('/dataMyagenda', [AgendaController::class, 'dataMyagenda']);

Route::get('/sendPaymentRequest', [TransactionController::class, 'sendPaymentRequest']);
Route::post('/paymentWebHook', [TransactionController::class, 'paymentWebHook']);

Route::get('/eod', [TransactionController::class, 'eod']);
Route::get('/voidtrans', [TransactionController::class, 'voidtrans']);
Route::get('/getbill', [TransactionController::class, 'getbill']);
Route::get('/gettransaction', [TransactionController::class, 'gettransaction']);
Route::post('/confirmPembayaran', [TransactionController::class, 'confirmPembayaran']);
Route::post('/confirmPembayaranMID', [TransactionController::class, 'confirmPembayaranMID']);

Route::get('/pivot', [ReportController::class, 'pivot']);

Route::middleware(['superadmin'])->group(function () {
    Route::get('/admin', [adminController::class, 'index'])->middleware('auth');
    Route::post('/subscribe', [adminController::class, 'subscribe'])->middleware('auth');
    Route::post('/unsubscribe', [adminController::class, 'unsubscribe'])->middleware('auth');
    Route::get('/updateisAktif', [adminController::class, 'updateisAktif'])->middleware('auth');
    Route::get('/adminlistpengelola', [adminController::class, 'adminlistpengelola'])->middleware('auth');
    Route::get('/admintagihan', [adminController::class, 'admintagihan'])->middleware('auth');
    Route::get('/adminpembayaran', [adminController::class, 'adminpembayaran'])->middleware('auth');
    Route::get('/dataPengelola', [adminController::class, 'dataPengelola'])->middleware('auth');
    Route::get('/dataTagihan', [adminController::class, 'dataTagihan'])->middleware('auth');
    Route::post('/dataTagihanInsert', [adminController::class, 'dataTagihanInsert'])->middleware('auth');
    Route::post('/dataTagihanUpdate', [adminController::class, 'dataTagihanUpdate'])->middleware('auth');
    Route::post('/dataTagihanDelete', [adminController::class, 'dataTagihanDelete'])->middleware('auth');
    Route::get('/dataPembayaran', [adminController::class, 'dataPembayaran'])->middleware('auth');
});

