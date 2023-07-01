<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;



/** patient route */
Route::post('/create/doctor', [DoctorController::class, 'create']);

Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {

    /** Doctor details*/
    Route::post('/submit/details',[DoctorController::class,'submitDoctorDetail']);
    Route::get('/get/details',[DoctorController::class,'getDoctorDetails']);

});
