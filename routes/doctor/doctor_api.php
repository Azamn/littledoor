<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MasterSlotController;
use Illuminate\Support\Facades\Route;



/** patient route */
Route::post('/create/doctor', [DoctorController::class, 'create']);

Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {

    /** Doctor details*/
    Route::post('/submit/details',[DoctorController::class,'submitDoctorDetail']);
    Route::get('/get/details',[DoctorController::class,'getDoctorDetails']);

    /** Doctor Time Slot */
    Route::post('/create/slot',[MasterSlotController::class,'createDoctorTimeSlot']);
    Route::delete('/delete/slot/{doctorSlotId}',[MasterSlotController::class,'deleteDoctorSlot']);

    /** Doctor Session Charge */
    Route::post('/create/update/sesion/charge',[DoctorController::class,'addorUpdateSessionCharge']);
    Route::post('/get/session/charge',[DoctorController::class,'getDoctorSession']);

    /** Doctor consultancy update */
    Route::post('update/availability/consultancy',[DoctorController::class,'updateAvailableConsultancy']);

});
