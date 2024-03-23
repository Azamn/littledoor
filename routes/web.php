<?php

use App\Http\Controllers\AdminManagementController;
use App\Models\MasterCategory;
use App\Models\MasterQuestion;
use App\Models\MasterSubCategory;
use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Models\SubCategoryQuestionMapping;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\DailyJournalController;
use App\Http\Controllers\MasterOptionsController;
use App\Http\Controllers\PortalServiceController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterQuestionController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\SubCategoryQuestionOptionMappingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Main.index');
});

//ADMIN
Route::middleware(AdminAccess::class)->group(function () {
    Route::prefix('admin')->group(function () {

        // Category
        Route::get('/category', function () {
            return view('Admin.Category.category-create');
        });
        Route::get('/get-all/categories', [MasterCategoryController::class, 'getAllThroughAdmin'])->name('get.all-categories');
        Route::post('/create/category', [MasterCategoryController::class, 'createThroughAdmin'])->name('create.category');
        Route::delete('/delete/category', [MasterCategoryController::class, 'delete'])->name('delete.category');
        Route::get('/change/category/status', [MasterCategoryController::class, 'changeCategoryStatus'])->name('category.change.status');
        Route::get('/edit/category/{categoryId}', [MasterCategoryController::class, 'edit'])->name('edit.ctageory');
        Route::post('/update/category/{categoryId}', [MasterCategoryController::class, 'update'])->name('update.category');
        // sub-category
        Route::get('/create-sub-category', [MasterSubCategoryController::class, 'getCategoriesData'])->name('get.create-category');
        Route::get('/get-all/sub-categories', [MasterSubCategoryController::class, 'getAllThroughAdmin'])->name('get.all-sub-categories');
        Route::post('/create/sub-category', [MasterSubCategoryController::class, 'create'])->name('create.sub-category');
        Route::delete('/delete/sub-category', [MasterSubCategoryController::class, 'delete'])->name('delete.sub-category');
        Route::get('/change/sub-category/status', [MasterSubCategoryController::class, 'changeSubCategoryStatus'])->name('sub-category.change.status');
        Route::get('/edit/sub-category/{categoryId}', [MasterSubCategoryController::class, 'edit'])->name('edit.sub-category');
        Route::post('/update/sub-category/{categoryId}', [MasterCategoryController::class, 'update'])->name('update.sub-category');
        // Question
        Route::get('/questions', function () {
            return view('Admin.Questions.questions-create');
        });
        Route::get('/get-all/questions', [MasterQuestionController::class, 'getAllThroughAdmin'])->name('get.questions');
        Route::get('/change/question/status', [MasterQuestionController::class, 'changeQuestionStatus'])->name('question.change.status');
        Route::post('/create/questions', [MasterQuestionController::class, 'createThroughAdmin'])->name('create.questions');
        Route::delete('/delete/question', [MasterQuestionController::class, 'delete'])->name('delete.question');
        Route::get('/edit/question/{questionId}', [MasterQuestionController::class, 'edit'])->name('edit.question');
        Route::post('/update/question/{questionId}', [MasterQuestionController::class, 'update'])->name('update.question');

        //options
        Route::get('/options', function () {
            return view('Admin.Options.options-create');
        });
        Route::get('/get-all/options', [MasterOptionsController::class, 'getAllThroughAdmin'])->name('get.options');
        Route::get('/change/option/status', [MasterOptionsController::class, 'changeOptionStatus'])->name('option.change.status');
        Route::post('/create/option', [MasterOptionsController::class, 'createThroughAdmin'])->name('create.options');
        Route::delete('/delete/option', [MasterOptionsController::class, 'delete'])->name('delete.option');
        Route::get('/edit/option/{optionId}', [MasterOptionsController::class, 'edit'])->name('edit.option');
        Route::post('/update/option/{optionId}', [MasterOptionsController::class, 'update'])->name('update.option');

        // Category question option mapping
        Route::get('/get-all/question-option-mapping', [SubCategoryQuestionOptionMappingController::class, 'getAll'])->name('get.all-mapping');
        Route::get('/get/create-page', [SubCategoryQuestionOptionMappingController::class, 'getSubCategoryQuestionAndOptionForCreate'])->name('get.create-mapping-data');
        Route::post('/create/sub-category-question-option-mapping', [SubCategoryQuestionOptionMappingController::class, 'create'])->name('create.sub-ctageory-question-option-mapping');
        Route::delete('/delete/sub-category-question-option-mapping', [SubCategoryQuestionOptionMappingController::class, 'delete'])->name('delete.sub-ctageory-question-option-mapping');
        Route::get('/edit/sub-category-question-option-mapping/{categoryQuestionMappingId}', [SubCategoryQuestionOptionMappingController::class, 'getSingleMapping'])->name('edit.sub-ctageory-question-option-mapping');
        Route::post('/update/sub-category-question-option-mapping/{categoryQuestionMappingId}', [SubCategoryQuestionOptionMappingController::class, 'update'])->name('update.sub-ctageory-question-option-mapping');

        /** Dashboard */
        Route::get('/dashboard',[AdminManagementController::class,'dashboardWidget'])->name('dashboard');
        // Route::get('/dashboard', function () {
        //     return view('Admin.dashboard');
        // })->name('dashboard');


        /** Doctor Route */
        Route::get('/get/doctor-list', [DoctorController::class, 'getDoctorList'])->name('get.all-doctors');
        Route::get('/change/doctor-status', [DoctorController::class, 'changeDoctorStatus'])->name('change.doctor-status');
        Route::get('/get/doctor/details/view/{doctorId}', [DoctorController::class, 'getDoctorDetailsView']);

        /** Patient Route */
        Route::get('/get/patient-list', [PatientController::class, 'getAllPatient'])->name('get.all-patient');

        /** Emotions Route */
        Route::post('create/emotions', [DailyJournalController::class, 'addEmotions'])->name('create.emotions');
        Route::get('/get-all/emotions', [DailyJournalController::class, 'getAllEmotionsThroughAdmin'])->name('get.all-emotions');
        Route::delete('/delete/emotions', [DailyJournalController::class, 'deleteEmotions'])->name('delete.emotions');
        Route::get('/change/emotion-status', [DailyJournalController::class, 'changeEmotionStatus'])->name('change.emotion-status');

        /** Promotion Route */
        Route::post('create/promotion',[PromotionController::class,'createPromotion'])->name('create.promotion');
        Route::get('/get-all/promotions',[PromotionController::class, 'getAllPromotionsThroughAdmin'])->name('get.all-promotions');
        Route::delete('/delete/promotion', [PromotionController::class, 'deletePromotion'])->name('delete.promotion');
        Route::get('/change/promotion-status', [PromotionController::class, 'changePromotionStatus'])->name('change.promotion-status');

        /** Privacy policy */
        Route::get('/privacy-policy', function () {
            return view('Admin.PrivacyPolicy.privacy-policy-create');
        });
        Route::post('/create/privacy-policy',[PrivacyPolicyController::class,'create'])->name('create.privacy-policy');
        Route::get('/get-all/privacy-policy',[PrivacyPolicyController::class,'getAllAdmin'])->name('get.privacy-policy');
        Route::get('/edit/privacy-policy/{privacyPolicyId}', [PrivacyPolicyController::class, 'edit'])->name('edit.privacy-policy');
        Route::post('/update/privacy-policy/{privacyPolicyId}', [PrivacyPolicyController::class, 'update'])->name('update.privacy-policy');
        Route::delete('/delete/privacy-policy',[PrivacyPolicyController::class,'delete'])->name('delete.privacy-policy');
        Route::get('/change/privacy-policy', [PrivacyPolicyController::class, 'changePrivacyPolicyStatus'])->name('change.privacy-policy-status');
        
        /** portal service */

        Route::get('/portal-service-charges-create', function () {
            return view('Admin.PortalService.portal-service-create');
        });

        Route::post('/create/portal/service/charges',[PortalServiceController::class,'createPortalService'])->name('create.portal-service');
        Route::get('/get-all/portal/service/charges',[PortalServiceController::class,'getAllAdmin'])->name('get.portal-service');
        Route::get('/edit/portal/service/charges/{portalServiceChargeId}', [PortalServiceController::class, 'edit'])->name('edit.portal-service');
        Route::post('/update/portal/service/charges/{portalServiceChargeId}', [PortalServiceController::class, 'update'])->name('update.portal-service');
        Route::delete('/delete/portal/service/charges',[PortalServiceController::class,'delete'])->name('delete.portal-service');

        /** Transaction Details */
        Route::get('/all-transactions/details',[TransactionDetailController::class,'getAllTransaction'])->name('get.all-transactions-details');
        Route::get('/get/doctor/payment/request',[TransactionDetailController::class,'doctorRequestPayment'])->name('get.doctor-payment-request');
        Route::get('/get/doctor/payment/done',[TransactionDetailController::class,'requestPaymentDone'])->name('get.doctor-payment-done');


    });

});


//Auth Routes

Route::get('/admin/login', [AuthController::class, 'loginShow'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.passowrd');
Route::get('/change-password', [AuthController::class, 'getChangePassword'])->name('get.change.passowrd');

Route::get('/privacy/policy',[PrivacyPolicyController::class,'getPrivacyPolicy']);


Route::post('/contact-us', [ContactUsController::class, 'createContactUs'])->name('store.contact-us');



Route::get('/admin/doctor-view', function () {
    return view('Admin.Doctor.doctor-view');
});

Route::get('/admin/emotion-list', function () {
    return view('Admin.Emotion.emotion-list');
});

Route::get('/admin/emotion-create', function () {
    return view('Admin.Emotion.emotion-create');
});


Route::get('/admin/promotion-list', function () {
    return view('Admin.Promotion.promotion-list');
});

Route::get('/admin/promotion-create', function () {
    return view('Admin.Promotion.promotion-create');
});

Route::get('/admin/promotion-view', function () {
    return view('Admin.Promotion.promotion-view');
});
