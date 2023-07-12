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

    /** Get category */
    Route::get('/get/categroy',[AdminManagementController::class,'getCategory']);

    /** Get All Questions With Options */
    Route::get('/get/questions',[AdminManagementController::class, 'getAllQuestionsWithOption']);

    /** Submit Patient question option */
    Route::post('/save/patient/question/response',[PatientController::class,'createPateintQuestionMappingOption']);

    /** Get languages */
    Route::get('/get/languages',[AdminManagementController::class,'getLanguages']);


});

Route::get('/get/cities',[MasterCityController::class,'getCity']);
