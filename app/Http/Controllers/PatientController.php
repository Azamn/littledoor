<?php

namespace App\Http\Controllers;

use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use App\Models\MasterPatient;
use Illuminate\Support\Carbon;
use App\Models\MasterSubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategoryQuestionMapping;
use App\Models\PatientQuestionOptionMapping;
use App\Http\Resources\MasterDoctorDetailResource;
use App\Models\DoctorTimeSlot;
use App\Models\PatientAppointment;
use App\Models\PatientMentalDisorderQuestionMapping;
use App\Models\SubCategoryQuestionMappingWithOption;

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
                    $user->master_user_type_id = 3;
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->update();

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
            'questions.*.sub_category_question_mapping_id' => 'required|integer',
            'questions.*.option_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                DB::transaction(function () use ($user, $request) {

                    $PatientQuestionOptionMapping = PatientQuestionOptionMapping::where('patient_id', $request->patient_id)->get();
                    if ($PatientQuestionOptionMapping->isNotEmpty()) {
                        foreach ($PatientQuestionOptionMapping as $mapping) {
                            $mapping->delete();
                        }
                    }

                    foreach ($request->questions as $questionMapping) {
                        $PatientQuestionOptionMapping = new PatientQuestionOptionMapping();
                        $PatientQuestionOptionMapping->patient_id = $request->patient_id;
                        $PatientQuestionOptionMapping->category_question_mapping_id = $questionMapping['sub_category_question_mapping_id'];
                        $PatientQuestionOptionMapping->option_id = $questionMapping['option_id'];
                        $PatientQuestionOptionMapping->save();
                    }

                    $patientResponseData = PatientQuestionOptionMapping::where('patient_id', $request->patient_id)->get();
                    if ($patientResponseData->isNotEmpty()) {

                        $uniqueOptionData = $patientResponseData->unique('option_id');
                        $duplicateOptionData = $patientResponseData->diff($uniqueOptionData);
                        if (!is_null($duplicateOptionData)) {
                            $optionData = $duplicateOptionData->first();
                        } else {
                            $optionData = $uniqueOptionData->first();
                        }

                        $subCategoryMappingData = SubCategoryQuestionMapping::where('id', $optionData->category_question_mapping_id)->first();

                        $subCategoryData = MasterSubCategory::where('id', $subCategoryMappingData->master_sub_category_id)->first();

                        $subCategoryId = $subCategoryData?->id;
                        $categoryId = $subCategoryData?->master_category_id;

                        $pateintData = MasterPatient::where('id', $request->patient_id)->first();
                        $pateintData->category_id = $categoryId ?? NULL;
                        $pateintData->sub_category_id = $subCategoryId ?? NULL;
                        $pateintData->update();
                    }
                });

                return response()->json(['status' => true, 'message' => 'Successfully submitted your response']);
            }
        }
    }

    public function getAllPatient(Request $request)
    {

        $patientData = [];

        $masterPatients = MasterPatient::with('user')->get();
        if ($masterPatients->isNotEmpty()) {

            foreach ($masterPatients as $patient) {

                $data = [
                    'id' => $patient->id,
                    'name' => $patient?->first_name,
                    'email' => $patient?->user?->email ?? NULL,
                    'mobile_no' => $patient?->user?->mobile_no ?? NULL,
                    'city' => $patient?->city?->city_name ?? NULL,
                ];

                array_push($patientData, $data);
            }
        }

        return view('Admin.Patient.patient-list', compact('patientData'));
    }

    public function testCategory(Request $request)
    {
        $patientResponseData = PatientQuestionOptionMapping::where('patient_id', $request->patient_id)->get();
        if ($patientResponseData->isNotEmpty()) {

            $uniqueOptionData = $patientResponseData->unique('option_id');
            $duplicateOptionData = $patientResponseData->diff($uniqueOptionData);
            if (!is_null($duplicateOptionData)) {
                $optionData = $duplicateOptionData->first();
            } else {
                $optionData = $uniqueOptionData->first();
            }

            $subCategoryMappingData = SubCategoryQuestionMapping::where('id', $optionData->category_question_mapping_id)->first();

            $subCategoryData = MasterSubCategory::where('id', $subCategoryMappingData->master_sub_category_id)->first();

            $subCategoryId = $subCategoryData?->id;
            $categoryId = $subCategoryData?->master_category_id;

            $pateintData = MasterPatient::where('id', $request->patient_id)->first();
            $pateintData->category_id = $categoryId ?? NULL;
            $pateintData->sub_category_id = $subCategoryId ?? NULL;
            $pateintData->update();
        }
    }

    public function getDoctor(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $patient = $user->patient;

            if ($patient) {

                $categoryId = $patient->category_id;

                $masterDoctor = collect();

                if ($categoryId) {
                    $masterDoctor = MasterDoctor::with(['doctorWorkMapping' => function ($query) use ($categoryId) {
                        return $query->where('category_id', $categoryId);
                    }], 'user', 'city','doctorSkillsMapping.skill','doctorAppreciationMapping.media','timeSlot','doctorSession')->where('status', 1)->get();
                }

                if ($masterDoctor->isEmpty()) {
                    $masterDoctor = MasterDoctor::with('doctorWorkMapping.category', 'doctorSkillsMapping.skill','doctorAppreciationMapping.media','timeSlot','user', 'city','doctorSession')->where('status', 1)->get();
                }
                //return $masterDoctor;
                return response()->json(['status' => true, 'data' => MasterDoctorDetailResource::collection($masterDoctor)]);
            }
        }
    }

    public function getDoctorAvailableSlot(Request $request){
        $rules = [
            'doctor_id' => 'required',
            'date' => 'soemtimes|required|date',
            'day_id' => 'required_if:date|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if($request->has('doctor_id') && $request->has('date')){

                $requestDate = Carbon::parse($request->date)->format('Y-m-d');

                $bookedSlotIds = PatientAppointment::where('doctor_id',$request->doctor_id)->whereDate('appointment_date','=',$requestDate)->pluck('slot_id')->toArray();
                if(!is_null($bookedSlotIds)){

                    $doctorSlot = DoctorTimeSlot::where('master_days_id',$request->day_id)->first();
                    if($doctorSlot){
                        $doctorSlotIds = explode(",",$doctorSlot->time_slot_id);

                    }

                }



            }

        }

    }
}
