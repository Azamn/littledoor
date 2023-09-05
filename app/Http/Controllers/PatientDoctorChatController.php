<?php

namespace App\Http\Controllers;

use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use App\Models\MasterPatient;
use Illuminate\Support\Facades\Validator;
use App\Models\PatientDoctorChat;

class PatientDoctorChatController extends Controller
{

    public function startChat(Request $request)
    {

        $rules = [
            'receiver_id' => 'required',
            'message' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $patientDoctorChatData = new PatientDoctorChat();
                $patientDoctorChatData->sender_id = $user->id;
                $patientDoctorChatData->receiver_id = $request->receiver_id;
                $patientDoctorChatData->message = $request->message;
                $patientDoctorChatData->save();
            }
        }
    }
}
