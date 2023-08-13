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
use App\Http\Controllers\MasterSlotController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\MentalDisorderCategoryController;
use App\Http\Controllers\MentalDisorderCategoryQuestionController;
use App\Http\Controllers\SubCategoryQuestionOptionMappingController;

Route::post('/register/login',[AdminManagementController::class,'login']);

Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {


    /** Master Category  */
    Route::post('/create/master/category',[MasterCategoryController::class, 'create']);
    Route::get('/get-all/master/category',[MasterCategoryController::class, 'getAll']);

    /** Master Sub Category */
    Route::post('create/master/sub-category',[MasterSubCategoryController::class, 'create']);
    Route::get('get-all/master/sub-category',[MasterSubCategoryController::class, 'getAll']);

    /** Master Question */
    Route::post('create/master/question',[MasterQuestionController::class, 'create']);
    Route::get('get-all/master/questions',[MasterQuestionController::class, 'getAll']);

    /** Master Options */
    Route::post('create/master/options',[MasterOptionsController::class, 'create']);
    Route::get('get-all/master/options',[MasterOptionsController::class, 'getAll']);

    /** Master Common API */
    Route::get('/get/categroy',[AdminManagementController::class,'getCategory']);
    Route::post('/get/sub/category',[AdminManagementController::class,'getSubCategory']);
    Route::get('/get/skills',[AdminManagementController::class,'getSkills']);

    /** Get All Questions With Options */
    Route::get('/get/questions',[AdminManagementController::class, 'getAllQuestionsWithOption']);

    /** Submit Patient question option */
    Route::post('/save/patient/question/response',[PatientController::class,'createPateintQuestionMappingOption']);

    /** user Details */
    Route::get('/get/user/details',[AdminManagementController::class,'getUserDetails']);
    Route::post('/update/user/details',[AdminManagementController::class,'updateUserDetails']);

    /** Get languages */
    Route::get('/get/languages',[AdminManagementController::class,'getLanguages']);

    /** GET Doctor list in pateint */
    Route::get('/get/doctor/list',[PatientController::class,'getDoctor']);

    /** TIme Slot */
    Route::get('get/all-slot',[MasterSlotController::class,'getTimeSlot']);

});

Route::get('/get/cities',[MasterCityController::class,'getCity']);
Route::get('/get/unique/category',[PatientController::class, 'testCategory']);
