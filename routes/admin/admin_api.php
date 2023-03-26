<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\MasterCityController;
use App\Http\Controllers\MentalDisorderCategoryController;
use App\Http\Controllers\MentalDisorderCategoryQuestionController;
use App\Http\Controllers\PatientController;
use App\Models\MentalDisorderCategory;
use Illuminate\Support\Facades\Route;


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

});

Route::get('/get/cities',[MasterCityController::class,'getCity']);
