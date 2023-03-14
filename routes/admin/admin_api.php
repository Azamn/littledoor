<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\MasterCityController;
use App\Http\Controllers\MentalDisorderCategoryController;
use App\Http\Controllers\PatientController;
use App\Models\MentalDisorderCategory;
use Illuminate\Support\Facades\Route;


Route::post('/register/login',[AdminManagementController::class,'login']);

Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class], function () {

    /** patient route */
    Route::post('/create/patient', [PatientController::class, 'create']);

    /** Mental Disorder Category Route */
    Route::post('/create/mental/disorder/category',[MentalDisorderCategoryController::class,'create']);
    Route::post('/get-all/mental/disorder/category',[MentalDisorderCategoryController::class,'getAll']);


});

Route::get('/get/cities',[MasterCityController::class,'getCity']);
