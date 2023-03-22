<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPatient;
use App\Models\PatientMentalDisorderQuestionMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{

    public function create(Request $request)
    {

        $rules = [
            'name' => 'required|string',
            'email' => 'required',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'city_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                DB::transaction(function () use ($user, $request) {

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->save();

                    $patient = new MasterPatient();
                    $patient->user_id = $user->id;
                    $patient->first_name = $request->name;
                    $patient->dob = $request->dob;
                    $patient->gender = $request->gender;
                    $patient->city_id = $request->city_id;

                    $patient->save();
                });

                return response()->json(['status' => true, 'message' => 'Basic Details Added Successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found.']);
            }
        }
    }

    public function createPatientQuestionMapping(Request $request)
    {

        $rules = [
            'patient_id' => 'required|integer',
            'mental_disorder_category_question_mapping_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $patientQuestionMappingExist = PatientMentalDisorderQuestionMapping::where('patient_id', $request->patient_id)->get();
                if ($patientQuestionMappingExist) {
                    foreach ($patientQuestionMappingExist as $patientQuestion) {
                        $patientQuestion->delete();
                    }
                }

                $patientQuestionMapping = new PatientMentalDisorderQuestionMapping();
                $patientQuestionMapping->user_id = $user->id;
                $patientQuestionMapping->patient_id = $request->patient_id;
                $patientQuestionMapping->mental_disorder_category_question_mapping_id = $request->mental_disorder_category_question_mapping_id;
                $patientQuestionMapping->save();

                return response()->json(['status' => true, 'message' => 'Your Input Submitted Successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found.']);
            }
        }
    }
}
