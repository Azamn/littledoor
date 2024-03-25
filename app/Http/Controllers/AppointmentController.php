<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTimeSlot;
use Illuminate\Support\Carbon;
use App\Models\PatientAppointment;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AppointmentDetailsResource;
use App\Models\FcmToken;
use App\Models\MasterDoctor;
use App\Models\UserNotification;
use App\Services\FCM\FCMService;

class AppointmentController extends Controller
{

    public function bookAppointment(Request $request)
    {

        $rules = [
            'doctor_id' => 'required|integer',
            'slot_id' => 'required|integer',
            'appointment_date' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $patient = $user->patient;

                if ($patient) {

                    $appointment = new PatientAppointment();
                    $appointment->patient_id = $patient->id;
                    $appointment->doctor_id = $request->doctor_id;
                    $appointment->appointment_date = $request->appointment_date;
                    $appointment->slot_id = $request->slot_id;
                    $appointment->save();


                    $eventNmae = 'Appointment Book';
                    $slotTime = NULL;
                    $slot = MasterTimeSlot::where('id', $request->slot_id)->first();
                    if ($slot) {
                        $slotTime = $slot->slot_time;
                    }

                    $doctor = MasterDoctor::where('id', $request->doctor_id)->first();
                    if ($doctor) {
                        if (!is_null($doctor?->first_name) && !is_null($doctor?->last_name)) {
                            $doctorName = $doctor?->first_name . ' ' . $doctor?->last_name;
                        } else {
                            $doctorName = $doctor?->first_name;
                        }
                    }

                    $title = "Doctor's Appointment";
                    $patientBody = 'The Appointment has been booked with Doctor ' . $doctorName . ' on the date of ' . Carbon::parse($request->appointment_date)->format('d-m-Y') . ' And your time slot is ' . $slotTime;

                    $patientUserId = $user->id;
                    $tokenData = FcmToken::where('user_id', $patientUserId)->select('fcm_token', 'user_id', 'platform_id')->get();

                    $fcmService = new FCMService();
                    $fcmService->sendNotifications($tokenData, $title, $patientBody, $eventNmae);


                    return response()->json(['status' => true, 'message' => 'Appointment Book Successfully.']);
                }
            }
        }
    }

    public function getAppointmentDetails(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $patient = $user->patient;
            $doctor = $user->doctor;

            if ($patient) {

                $patientAppointment = PatientAppointment::with('slot', 'doctor', 'patient')->where('patient_id', $patient->id)->get();
                if ($patientAppointment->isNotEmpty()) {
                    return response()->json(['status' => true, 'data' => AppointmentDetailsResource::collection($patientAppointment)]);
                }
            } elseif ($doctor) {
                $doctorAppointment = PatientAppointment::with('slot', 'doctor', 'patient')->where('doctor_id', $doctor->id)->get();
                if ($doctorAppointment->isNotEmpty()) {
                    return response()->json(['status' => true, 'data' => AppointmentDetailsResource::collection($doctorAppointment)]);
                }
            }
        }
    }
}
