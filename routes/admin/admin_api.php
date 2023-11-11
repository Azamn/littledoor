<?php

use App\Models\MasterCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\XSSProtection;
use App\Models\MentalDisorderCategory;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MasterCityController;
use App\Http\Middleware\SecureRequestMiddleware;
use App\Http\Controllers\MasterOptionsController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterQuestionController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DailyJournalController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MasterSlotController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\MentalDisorderCategoryController;
use App\Http\Controllers\MentalDisorderCategoryQuestionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\SubCategoryQuestionOptionMappingController;
use App\Http\Controllers\UserNotificationController;

Route::post('/register/login', [AdminManagementController::class, 'login']);

Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {


    /** Master Category  */
    Route::post('/create/master/category', [MasterCategoryController::class, 'create']);
    Route::get('/get-all/master/category', [MasterCategoryController::class, 'getAll']);

    /** Master Sub Category */
    Route::post('create/master/sub-category', [MasterSubCategoryController::class, 'create']);
    Route::get('get-all/master/sub-category', [MasterSubCategoryController::class, 'getAll']);

    /** Master Question */
    Route::post('create/master/question', [MasterQuestionController::class, 'create']);
    Route::get('get-all/master/questions', [MasterQuestionController::class, 'getAll']);

    /** Master Options */
    Route::post('create/master/options', [MasterOptionsController::class, 'create']);
    Route::get('get-all/master/options', [MasterOptionsController::class, 'getAll']);

    /** Master Common API */
    Route::get('/get/categroy', [AdminManagementController::class, 'getCategory']);
    Route::post('/get/sub/category', [AdminManagementController::class, 'getSubCategory']);
    Route::get('/get/skills', [AdminManagementController::class, 'getSkills']);

    /** Get All Questions With Options */
    Route::get('/get/questions', [AdminManagementController::class, 'getAllQuestionsWithOption']);

    /** Submit Patient question option */
    Route::post('/save/patient/question/response', [PatientController::class, 'createPateintQuestionMappingOption']);

    /** user Details */
    Route::get('/get/user/details', [AdminManagementController::class, 'getUserDetails']);
    Route::post('/update/user/details', [AdminManagementController::class, 'updateUserDetails']);

    /** Get languages */
    Route::get('/get/languages', [AdminManagementController::class, 'getLanguages']);

    /** GET Doctor list in pateint */
    Route::get('/get/doctor/list', [PatientController::class, 'getDoctor']);

    /** TIme Slot */
    Route::get('get/all-slot', [MasterSlotController::class, 'getTimeSlot']);

    /** Emotions URL */
    Route::post('/add/emotions', [DailyJournalController::class, 'addEmotions']);
    Route::get('get/all/emotions', [DailyJournalController::class, 'getAllEmotions']);

    /** POST URL Explorer */
    Route::post('/add/post', [PostController::class, 'createPost']);
    Route::post('/add/post-like', [PostController::class, 'addPostLike']);
    Route::post('/add/post-comment', [PostController::class, 'addPostComment']);
    Route::get('/get/all-post', [PostController::class, 'getAllPost']);
    Route::get('/get/user-post', [PostController::class, 'getUserPost']);
    Route::delete('/delete/post/{postId}', [PostController::class, 'deletePost']);
    Route::post('/get/post-comments', [PostController::class, 'getPostComment']);
    Route::get('/user/comment-post', [PostController::class, 'getUserCommentPost']);
    Route::get('/user/likes-post', [PostController::class, 'getUserLikePost']);

    /** Promotions */
    Route::get('/get/promotions', [PromotionController::class, 'getPromotions']);

    /** Chat Routes */
    Route::post('/get/chat/messages', [ChatController::class, 'index']);
    Route::post('/sent/messages', [ChatController::class, 'store']);

    Route::post('/create/chat', [ChatController::class, 'createChat']);
    Route::get('/get/chat', [ChatController::class, 'getChat']);

    /**Notification */
    Route::get('/get/user-notification', [UserNotificationController::class, 'getUserNotification']);
    Route::post('/read/notification',[UserNotificationController::class,'updateIsRead']);

    /** Route :: Payment Route  */
    Route::post('create-payment/order', [RazorPayController::class, 'createPaymentOrder']);
    Route::post('verify-order/payment', [RazorPayController::class, 'verifyOrderPayment']);

    //Logout
    Route::post('/logout',[AdminManagementController::class,'logout'])->name('user.logout');

    /** Payment Request  */
    Route::get('/all/user/transaction',[DoctorController::class,'getUserTransaction']);
    Route::post('/request/amout-payment',[DoctorController::class,'paymentrequest']);
    Route::get('/get/revenue',[DoctorController::class,'getDoctorRevenue']);

    /** portal service */
    Route::post('/create/portal/service-charges',[AdminManagementController::class,'createPortalService']);

});

Route::get('/get/cities', [MasterCityController::class, 'getCity']);
Route::get('/get/unique/category', [PatientController::class, 'testCategory']);
