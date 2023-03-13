<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\MasterCityController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;


Route::post('/register/login',[AdminManagementController::class,'login']);

Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class], function () {

    Route::post('/create/patient', [PatientController::class, 'create']);

});

Route::get('/get/cities',[MasterCityController::class,'getCity']);
