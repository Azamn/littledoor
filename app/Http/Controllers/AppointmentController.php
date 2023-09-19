<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientAppointment;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AppointmentDetailsResource;

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

                    return response()->json(['status' => true, 'message' => 'Appointment Book Successfully.']);
                }
            }
        }
    }

    public function getAppointmentDetails(Request $request){

        $user = $request->user();

        if($user){

            $patient = $user->patient;
            $doctor = $user->doctor;

            if($patient){

                $patientAppointment = PatientAppointment::with('slot','doctor','patient')->where('patient_id',$patient->id)->get();
                if($patientAppointment->isNotEmpty()){
                    return response()->json(['status' => true, 'data' => AppointmentDetailsResource::collection($patientAppointment)]);
                }
            }elseif($doctor){
                $doctorAppointment = PatientAppointment::with('slot','doctor','patient')->where('doctor_id',$doctor->id)->get();
                if($doctorAppointment->isNotEmpty()){
                    return response()->json(['status' => true, 'data' => AppointmentDetailsResource::collection($doctorAppointment)]);
                }
            }


        }

    }
}