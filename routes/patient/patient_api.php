<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DailyJournalController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'auth:api', SecureRequestMiddleware::class, XSSProtection::class], function () {

    /** patient route */
    Route::post('/create/patient', [PatientController::class, 'create']);

    /** Patient question mapping */
    Route::post('/create/patient/question',[PatientController::class,'createPatientQuestionMapping']);

    Route::post('/create/patient/question-option',[PatientController::class,'createPatientQuestionoptionMapping']);

    /** Daily Journal route */
    Route::post('add/daily/journal',[DailyJournalController::class,'addDailyJournal']);
    Route::get('get/daily/journal',[DailyJournalController::class,'getUserJournal']);
    Route::delete('delete/daily/journal/{dailyJournalId}',[DailyJournalController::class,'deleteUserJournal']);

    /** Appointment Route */
    Route::post('/book/appointment',[AppointmentController::class,'bookAppointment']);
    Route::post('/available/slot/book',[PatientController::class,'getDoctorAvailableSlot']);

});
