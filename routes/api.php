<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MaintenanceWorkShopsController;
use App\Http\Controllers\MediatorAppointmentController;
use App\Http\Controllers\MediatorController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OwnershipDocumentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'index']
);

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('user.register');
    Route::post('/verifyotp', 'verifyOtp')->name('user.verification');
    Route::post('/login', 'login')->name('user.login');
    Route::post('/forgetpassword', 'forgetPassword')->name('user.forgetpassword');
    Route::post('/resetpassword', 'resetPassword')->name('user.resetpassword');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/delete-account', [AuthController::class, 'deleteAccount']);
});


Route::middleware('auth:sanctum')->controller(PropertyController::class)->group(function () {
    Route::post('/property/create', 'createProperty');
    Route::get('/property/me', 'userproperty');
    Route::post('/property/update/{id}', 'updateProperty');
    Route::delete('/property/delete/{id}', 'deleteProperty');
    Route::post('/property/filter', 'filterProperty');
});

 
    // أي مستخدم يمكنه عرض العقارات
    Route::get('/property/getall', [PropertyController::class, 'index']);
    Route::get('/property/show/{id}', [PropertyController::class, 'show']);


Route::middleware('auth:sanctum')->controller(PropertyImageController::class)->group(function(){
    Route::post('/property/image/add/{property_id}','addImage');
    Route::delete('/property/image/delete/{id}','deleteImage');
    Route::get('/property/image/geturl/{id}','getImageUrl');
});



Route::middleware('auth:sanctum')->controller(DocumentController::class)->group(function(){
    Route::post('/property/document/add/{property_id}','addDocument');
    Route::delete('/property/document/delete/{id}','deleteDocument');
    Route::get('/property/document/geturl/{id}','getDocument');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites/get', [FavoriteController::class, 'index']);
    Route::post('/favorites/store/{property_id}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/delete/{property_id}', [FavoriteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/property/ratings/{property_id}', [RatingController::class, 'index']);
    Route::post('/ratings/store', [RatingController::class, 'store']);
    Route::delete('/ratings/delete/{rating_id}', [RatingController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/workshops/get', [MaintenanceWorkShopsController::class, 'index']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('banks', [BankController::class, 'index']);
    Route::get('banks/show/{id}', [BankController::class, 'show']);
    });

 Route::middleware('auth:sanctum')->group(function () {
 Route::get('/wallet', [WalletController::class, 'index']);
Route::post('/wallet/deposit', [WalletController::class, 'deposit']);
Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);

});






Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
});




// 🔹 Reservations
Route::middleware('auth:sanctum')->controller(ReservationController::class)->group(function () {
    Route::get('/reservations', 'index');                  // كل الحجوزات
    Route::post('/reservations/create', 'store');          // إنشاء حجز
    Route::get('/reservations/{id}', 'show');              // عرض حجز
    Route::put('/reservations/update/{id}', 'update');     // تحديث حجز
    Route::delete('/reservations/delete/{id}', 'destroy'); // حذف حجز
});

// 🔹 Payments
Route::middleware('auth:sanctum')->controller(PaymentController::class)->group(function () {
    Route::get('/payments', 'index');                       // كل الدفعات
    Route::post('/payments/create', 'store');               // إنشاء دفعة
    Route::get('/payments/{id}', 'show');                   // عرض دفعة
    Route::put('/payments/update/{id}', 'update');          // تحديث دفعة
    Route::delete('/payments/delete/{id}', 'destroy');      // حذف دفعة
});

// 🔹 Invoices
Route::middleware('auth:sanctum')->controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index');                       // كل الفواتير
    Route::post('/invoices/create', 'store');               // إنشاء فاتورة
    Route::get('/invoices/{id}', 'show');                   // عرض فاتورة
    Route::put('/invoices/update/{id}', 'update');          // تحديث فاتورة
    Route::delete('/invoices/delete/{id}', 'destroy');      // حذف فاتورة
});

// 🔹 Ownership Documents
Route::middleware('auth:sanctum')->controller(OwnershipDocumentController::class)->group(function () {
    Route::get('/documents', 'index');                       // كل الوثائق
    Route::post('/documents/create', 'store');               // رفع وثيقة
    Route::get('/documents/{id}', 'show');                   // عرض وثيقة
    Route::put('/documents/update/{id}', 'update');          // تحديث وثيقة
    Route::delete('/documents/delete/{id}', 'destroy');      // حذف وثيقة
});








Route::middleware('auth:sanctum')->controller(MessageController::class)->group(function () {
    Route::get('/messages', 'index');                    // عرض كل الرسائل للمستخدم
    Route::post('/messages/create', 'store');            // إرسال رسالة جديدة
    Route::get('/messages/{id}', 'show');                // عرض رسالة واحدة
    Route::put('/messages/update/{id}', 'update');       // تعديل رسالة
    Route::delete('/messages/delete/{id}', 'destroy');   // حذف رسالة
});







Route::middleware('auth:sanctum')->controller(MediatorController::class)->group(function () {
    Route::get('/mediators', 'index');
    Route::post('/mediators/create', 'store');
    Route::get('/mediators/{id}', 'show');
    Route::put('/mediators/update/{id}', 'update');
    Route::delete('/mediators/delete/{id}', 'destroy');
});

Route::middleware('auth:sanctum')->controller(MediatorAppointmentController::class)->group(function () {
    Route::get('/appointments', 'index');
    Route::post('/appointments/create', 'store');
    Route::get('/appointments/{id}', 'show');
    Route::put('/appointments/update/{id}', 'update');
    Route::delete('/appointments/delete/{id}', 'destroy');
});



////////////admin+super_admin

   // الموافقة على العقارات (خاص بالـ admin / super-admin)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/property/status', [PropertyController::class,'changeStatus']); 
        Route::post('/property/approve/{id}', [PropertyController::class, 'approve']);
    });



    
// إرسال إشعارات للمستخدمين (خاص بالـ admin / super-admin)
Route::middleware(['auth:sanctum','role:admin|super_admin'])->prefix('admin')->group(function () {
    Route::post('/notifications', [NotificationController::class, 'store']); 
});

// إنشاء وحذف ورش صيانة (خاص بالـ admin / super-admin)
Route::middleware(['auth:sanctum','role:admin|super_admin'])->group(function () {
    Route::post('/workshops/create', [MaintenanceWorkShopsController::class, 'store']);
    Route::delete('/workshops/delete/{WorkShopsId}', [MaintenanceWorkShopsController::class, 'destroy']);
});

   // admin / super-admin فقط لإنشاء، تعديل، حذف البنوك
    Route::middleware('role:admin|super_admin')->group(function () {
        Route::post('banks/create', [BankController::class, 'store']);
        Route::put('banks/update/{id}', [BankController::class, 'update']);
        Route::delete('banks/delete/{id}', [BankController::class, 'destroy']);
    });
    // لارجاع عدد المستخدمين و عدد العقارات 
    Route::middleware(['auth:sanctum',])->group(function () {
    Route::get('/user/count', [AuthController::class, 'count']);
    Route::get('/property/count', [PropertyController::class, 'count']);
});


