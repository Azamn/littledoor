<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {

    /** patient route */
    Route::post('/create/patient', [PatientController::class, 'create']);

    /** Patient question mapping */
    Route::post('/create/patient/question',[PatientController::class,'createPatientQuestionMapping']);

});
