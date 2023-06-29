<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {

    /** patient route */
    Route::post('/create/doctor', [DoctorController::class, 'create']);

});
