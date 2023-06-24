<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPatient;
use App\Models\PatientMentalDisorderQuestionMapping;
use App\Models\PatientQuestionOptionMapping;
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


    public function createPateintQuestionMappingOption(Request $request)
    {
        $rules = [
            'patient_id' => 'required',
            'questions.*.category_question_mapping_id' => 'required|integer',
            'questions.*.option_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $PatientQuestionOptionMapping = PatientQuestionOptionMapping::where('patient_id',$request->patient_id)->get();
                if($PatientQuestionOptionMapping->isNotEmpty()){
                    foreach($PatientQuestionOptionMapping as $mapping){
                        $mapping->delete();
                    }
                }

                foreach ($request->questions as $questionMapping) {
                    $PatientQuestionOptionMapping = new PatientQuestionOptionMapping();
                    $PatientQuestionOptionMapping->patient_id = $request->patient_id;
                    $PatientQuestionOptionMapping->category_question_mapping_id = $questionMapping['category_question_mapping_id'];
                    $PatientQuestionOptionMapping->option_id = $questionMapping['option_id'];
                    $PatientQuestionOptionMapping->save();
                }

                return response()->json(['status' => true, 'message' => 'Successfully submitted your response']);
            }
        }
    }
}
