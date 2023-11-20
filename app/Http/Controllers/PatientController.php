<?php

namespace App\Http\Controllers;

use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use App\Models\MasterPatient;
use App\Models\DoctorTimeSlot;
use App\Models\MasterTimeSlot;
use Illuminate\Support\Carbon;
use App\Models\MasterSubCategory;
use App\Models\PatientAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategoryQuestionMapping;
use App\Models\PatientQuestionOptionMapping;
use App\Http\Resources\MasterTimeSlotResource;
use App\Http\Resources\MasterDoctorDetailResource;
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
                    } elseif (!is_null($uniqueOptionData)) {
                        $optionData = $uniqueOptionData->first();
                    } else {
                        $optionData = $patientResponseData->first();
                    }

                    if ($optionData) {

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

        $rules = [
            'search_doctor' => 'sometimes|required|string',
            'category' => 'sometimes|required',
            'sub_category' => 'sometimes|required',
            'city_name' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $patient = $user->patient;

                if ($patient) {
                    $masterDoctor = collect();

                    if ($request->has('search_doctor')) {
                        $masterDoctor = MasterDoctor::with('doctorWorkMapping', 'user', 'city', 'doctorSkillsMapping.skill', 'doctorAppreciationMapping.media', 'timeSlot', 'doctorSession')
                        ->where('status', 1)
                        ->where('first_name', 'like', '%'.$request->name. '%')
                        ->get();
                    } elseif ($request->has('sub_category')) {

                        $subCategory = MasterSubCategory::whereLike('name', $request->sub_category)->first();
                        if ($subCategory) {
                            $masterDoctor = MasterDoctor::with(['doctorWorkMapping' => function ($query) use ($subCategory) {
                                return $query->where('category_id', $subCategory->master_category_id);
                            }], 'user', 'city', 'doctorSkillsMapping.skill', 'doctorAppreciationMapping.media', 'timeSlot', 'doctorSession')

                                ->where('status', 1)->get();
                        }
                    } elseif ($request->has('sub_category') && $request->has('city_name')) {
                        $subCategory = MasterSubCategory::whereLike('name', $request->sub_category)->first();
                        if ($subCategory) {
                            $masterDoctor = MasterDoctor::with(['doctorWorkMapping' => function ($query) use ($subCategory) {
                                return $query->where('category_id', $subCategory->master_category_id);
                            }, 'city' => function ($query) use ($request) {
                                return $query->where('city_name', 'like', '%'. $request->city_name. '%');
                            }], 'user', 'doctorSkillsMapping.skill', 'doctorAppreciationMapping.media', 'timeSlot', 'doctorSession')

                                ->where('status', 1)->get();
                        }
                    } else {
                        $categoryId = $patient->category_id;

                        if ($categoryId) {
                            $masterDoctor = MasterDoctor::with(['doctorWorkMapping' => function ($query) use ($categoryId) {
                                return $query->where('category_id', $categoryId);
                            }], 'user', 'city', 'doctorSkillsMapping.skill', 'doctorAppreciationMapping.media', 'timeSlot', 'doctorSession')->where('status', 1)->get();
                        }

                        if ($masterDoctor->isEmpty()) {
                            $masterDoctor = MasterDoctor::with('doctorWorkMapping.category', 'doctorSkillsMapping.skill', 'doctorAppreciationMapping.media', 'timeSlot', 'user', 'city', 'doctorSession')->where('status', 1)->get();
                        }
                    }


                    // return $masterDoctor;
                    return response()->json(['status' => true, 'data' => MasterDoctorDetailResource::collection($masterDoctor)]);
                }
            }
        }
    }

    public function getDoctorAvailableSlot(Request $request)
    {
        $rules = [
            'doctor_id' => 'required',
            'date' => 'sometimes|required|date',
            'day_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if ($request->has('doctor_id') && $request->has('date')) {

                $requestDate = Carbon::parse($request->date)->format('Y-m-d');

                $bookedSlotIds = PatientAppointment::where('doctor_id', $request->doctor_id)->whereDate('appointment_date', '=', $requestDate)->pluck('slot_id')->toArray();
                if (!is_null($bookedSlotIds)) {

                    $doctorSlot = DoctorTimeSlot::where('master_days_id', $request->day_id)->where('doctor_id', $request->doctor_id)->first();
                    if ($doctorSlot) {

                        $slotData = [];

                        $doctorSlotIds = explode(",", $doctorSlot->time_slot_id);

                        $masterTimeSlot = MasterTimeSlot::where('status', 1)->whereIn('id', $doctorSlotIds)->get();

                        $bookedSlotData = $masterTimeSlot->whereIn('id', $bookedSlotIds);
                        if ($bookedSlotData) {
                            foreach ($bookedSlotData as $bSlotData) {
                                $data = [
                                    'id' => $bSlotData->id,
                                    'slot_time' => $bSlotData->slot_time,
                                    'is_booked' => 1
                                ];

                                array_push($slotData, $data);
                            }
                        }

                        $availableSlotData = $masterTimeSlot->whereNotIn('id', $bookedSlotIds);

                        if ($availableSlotData) {
                            foreach ($availableSlotData as $aSlotData) {
                                $data = [
                                    'id' => $aSlotData->id,
                                    'slot_time' => $aSlotData->slot_time,
                                    'is_booked' => 0
                                ];

                                array_push($slotData, $data);
                            }
                        }

                        $sortedArray = collect($slotData)->sortBy('id');

                        return response()->json(['status' => true, 'data' => $sortedArray->values()]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Slot Not Found']);
                    }
                } else {
                    $doctorSlot = DoctorTimeSlot::where('master_days_id', $request->day_id)->where('doctor_id', $request->doctor_id)->first();
                    if ($doctorSlot) {
                        $doctorSlotIds = explode(",", $doctorSlot->time_slot_id);
                        $masterTimeSlot = MasterTimeSlot::where('status', 1)->whereIn('id', $doctorSlotIds)->get();
                        $availableSlotData = $masterTimeSlot->whereNotIn('id', $bookedSlotIds);

                        $slotData = [];

                        if ($availableSlotData) {
                            foreach ($availableSlotData as $aSlotData) {
                                $data = [
                                    'id' => $aSlotData->id,
                                    'slot_time' => $aSlotData->slot_time,
                                    'is_booked' => 0
                                ];

                                array_push($slotData, $data);
                            }
                        }

                        $sortedArray = collect($slotData)->sortBy('id');

                        return response()->json(['status' => true, 'data' => $sortedArray->values()]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Slot Not Found']);
                    }
                }
            } else {

                $todayDate = Carbon::parse(today())->format('Y-m-d');

                $bookedSlotIds = PatientAppointment::where('doctor_id', $request->doctor_id)->whereDate('appointment_date', '=', $todayDate)->pluck('slot_id')->toArray();
                if (!is_null($bookedSlotIds)) {
                    $doctorSlot = DoctorTimeSlot::where('master_days_id', $request->day_id)->where('doctor_id', $request->doctor_id)->first();
                    if ($doctorSlot) {

                        $slotData = [];

                        $doctorSlotIds = explode(",", $doctorSlot->time_slot_id);

                        $masterTimeSlot = MasterTimeSlot::where('status', 1)->whereIn('id', $doctorSlotIds)->get();

                        $bookedSlotData = $masterTimeSlot->whereIn('id', $bookedSlotIds);
                        if ($bookedSlotData) {
                            foreach ($bookedSlotData as $bSlotData) {
                                $data = [
                                    'id' => $bSlotData->id,
                                    'slot_time' => $bSlotData->slot_time,
                                    'is_booked' => 1
                                ];

                                array_push($slotData, $data);
                            }
                        }

                        $availableSlotData = $masterTimeSlot->whereNotIn('id', $bookedSlotIds);

                        if ($availableSlotData) {
                            foreach ($availableSlotData as $aSlotData) {
                                $data = [
                                    'id' => $aSlotData->id,
                                    'slot_time' => $aSlotData->slot_time,
                                    'is_booked' => 0
                                ];

                                array_push($slotData, $data);
                            }
                        }

                        $sortedArray = collect($slotData)->sortBy('id');

                        return response()->json(['status' => true, 'data' => $sortedArray->values()]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Slot Not Found']);
                    }
                } else {

                    $doctorSlot = DoctorTimeSlot::where('master_days_id', $request->day_id)->where('doctor_id', $request->doctor_id)->first();
                    if ($doctorSlot) {
                        $doctorSlotIds = explode(",", $doctorSlot->time_slot_id);
                        $masterTimeSlot = MasterTimeSlot::where('status', 1)->whereIn('id', $doctorSlotIds)->get();
                        $availableSlotData = $masterTimeSlot->whereNotIn('id', $bookedSlotIds);

                        $slotData = [];

                        if ($availableSlotData) {
                            foreach ($availableSlotData as $aSlotData) {
                                $data = [
                                    'id' => $aSlotData->id,
                                    'slot_time' => $aSlotData->slot_time,
                                    'is_booked' => 0
                                ];

                                array_push($slotData, $data);
                            }
                        }

                        $sortedArray = collect($slotData)->sortBy('id');

                        return response()->json(['status' => true, 'data' => $sortedArray->values()]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Slot Not Found']);
                    }
                }
            }
        }
    }
}
