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

    /** Mental Disorder Category Route */
    Route::post('/create/mental/disorder/category',[MentalDisorderCategoryController::class,'create']);
    Route::get('/get-all/mental/disorder/category',[MentalDisorderCategoryController::class,'getAll']);
    Route::delete('/delete/mental/disorder/category/{mentalDisorderCategoriId}',[MentalDisorderCategoryController::class,'delete']);

    /**Mental Disorder Question Mapping Route */
    Route::post('/create/mental/disorder/category/question',[MentalDisorderCategoryQuestionController::class,'create']);
    Route::get('/get-all/mental/disorder/category/question',[MentalDisorderCategoryQuestionController::class,'getAll']);
    Route::delete('/delete/mental/disorder/category/question/{mentalDisorderQuestionId}',[MentalDisorderCategoryQuestionController::class,'create']);

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

    /** SubCategory Question options Mapping  */
    Route::post('create/sub-category/question/option/mapping',[SubCategoryQuestionOptionMappingController::class,'create']);


    /** Get All Questions With Options */
    Route::get('/get-all/questions/options',[AdminManagementController::class,'getAllQuestionsWithOption']);



});

Route::get('/get/cities',[MasterCityController::class,'getCity']);
