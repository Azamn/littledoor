<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Str;
use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorSubCategoryMapping;
use Illuminate\Support\Facades\Validator;
use App\Models\DoctorWorkExperienceMapping;
use App\Http\Resources\DoctorWorkExperienceResource;
use App\Models\DoctorEducationMapping;
use App\Models\DoctorSkillsMapping;

class DoctorController extends Controller
{

    public function create(Request $request)
    {

        $rules = [
            'name' => 'required|string',
            'email' => 'required',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'city_id' => 'required|integer',
            'address_line_1' => 'required|string',
            'mobile_no' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {


            if ($request->has('mobile_no') && !is_null($request->mobile_no)) {
                DB::transaction(function () use ($request) {

                    $apiToken = Str::random(60);
                    $rememberToken = Str::random(80);

                    $user = new User();
                    $user->master_user_type_id = 2;
                    $user->api_token = $apiToken;
                    $user->remember_token = $rememberToken;
                    $user->mobile_no = $request->mobile_no;
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->save();

                    $doctor = new MasterDoctor();
                    $doctor->user_id = $user->id;
                    $doctor->first_name = $request->name;
                    $doctor->dob = $request->dob;
                    $doctor->gender = $request->gender;
                    $doctor->contact_1 = $request->mobile_no;
                    $doctor->address_line_1 = $request->address_line_1;
                    $doctor->city_id = $request->city_id;

                    $doctor->save();
                });

                return $this->sendLoginOtp($request->mobile_no);
            }
        }
    }

    public function sendLoginOtp($mobileNumber)
    {

        $otp = rand(100000, 999999);
        $validTill = now()->addMinutes(15);

        if ($mobileNumber) {
            $userExist = User::where('mobile_no', $mobileNumber)->first();
            if ($userExist) {
                $userId = $userExist->id;
                $existingOtps = UserOtp::where('user_id', $userId)->first();
                // $existingOtps->each->delete();  // this is will uncomment when sms kit available
                if (is_null($existingOtps)) {
                    UserOtp::create([
                        'user_id' => $userId,
                        'otp' => $otp,
                        // 'valid_till' => $validTill,
                    ]);
                    $existOtp = $otp;
                } else {
                    $existOtp = $existingOtps->otp;
                }
            }
            return response()->json(['status' => true, 'message' => 'Basic details save and Otp Sent Successfully', 'otp' => $existOtp]);
        } else {
            return response()->json(['status' => false, 'message' => 'Otp Not Sent']);
        }
    }

    public function submitDoctorDetail(Request $request)
    {

        $rules = [
            'step' => 'required|integer',
            'work' => 'required_if:step,1|array',
            'work.*.category_id' => 'required|integer',
            'work.*.sub_category_id' => 'sometimes|required|string',
            'work.*.year_of_experience' => 'sometimes|required|integer',
            'work.*.certificate.*' => 'sometimes|nullable|file|mimes:jpg,png,jpeg|max:5000',
            'work.*.description' => 'sometimes|required|string',

            'education' => 'required_if:step,2|array',
            'education.*.name' => 'sometimes|required',
            'education.*.institution_name' => 'sometimes|required',
            'education.*.field_of_study' => 'sometimes|required',
            'education.*.start_date' => 'sometimes|date|required',
            'education.*.end_date' => 'sometimes|date|required',
            'education.*.certificate.*' => 'sometimes|required',
            'education.*.description' => 'sometimes|required',

            'skills.*' => 'required_if:step,3',




        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $doctor = MasterDoctor::where('user_id', $user->id)->first();

                if ($doctor) {

                    if ($request->has('step') && $request->step == 1) {

                        foreach ($request->work as $workData) {
                            $doctorWorkMapping = new DoctorWorkExperienceMapping();
                            $doctorWorkMapping->doctor_id = $doctor->id;
                            $doctorWorkMapping->category_id = $workData['category_id'] ?? NULL;
                            $doctorWorkMapping->sub_category_id = $workData['sub_category_id'] ?? NULL;
                            $doctorWorkMapping->year_of_experience = $workData['year_of_experience'] ?? NULL;
                            if ($workData['certificate']) {
                                foreach ($workData['certificate'] as $certificates) {
                                    $doctorWorkMapping->addMedia($certificates)->toMediaCollection('doctor-work-certificate');
                                }
                            }

                            if ($workData['description']) {
                                $doctorWorkMapping->description = $workData['description'] ?? NULL;
                            }

                            $doctorWorkMapping->save();
                        }

                        return response()->json(['status' => true, 'message' => 'Work Experience Save Successfully']);
                    }

                    if ($request->has('step') && $request->step == 2) {
                        foreach ($request->education as $deucationData) {
                            $doctorEducationMapping = new DoctorEducationMapping();
                            $doctorEducationMapping->doctor_id = $doctor->id;
                            $doctorEducationMapping->name = $deucationData['name'] ?? NULL;
                            $doctorEducationMapping->institution_name = $deucationData['institution_name'] ?? NULL;
                            $doctorEducationMapping->field_of_study = $deucationData['field_of_study'] ?? NULL;
                            $doctorEducationMapping->start_date = $deucationData['start_date'] ?? NULL;
                            $doctorEducationMapping->end_date = $deucationData['end_date'] ?? NULL;

                            if ($deucationData['certificate']) {
                                foreach ($deucationData['certificate'] as $certificates) {
                                    $doctorEducationMapping->addMedia($certificates)->toMediaCollection('doctor-edu-certificate');
                                }
                            }

                            if ($deucationData['description']) {
                                $doctorEducationMapping->description = $deucationData['description'] ?? NULL;
                            }

                            $doctorEducationMapping->save();
                        }

                        return response()->json(['status' => true, 'message' => 'Education Details Save Successfully']);
                    }

                    if ($request->has('step') && $request->step == 3) {
                        foreach ($request->skills as $skill) {
                            $doctorSkillsMapping = new DoctorSkillsMapping();
                            $doctorSkillsMapping->doctor_id = $doctor->id;
                            $doctorSkillsMapping->skill_name = $skill;
                            $doctorSkillsMapping->save();
                        }

                        return response()->json(['status' => true, 'message' => 'Skills Details Save Successfully']);
                    }

                } else {
                    return response()->json(['status' => false, 'message' => 'Doctor Data Not Found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found']);
            }
        }
    }

    public function getDoctorDetails(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $masterDoctor = MasterDoctor::with('doctorWorkMapping.media')->where('user_id', $user->id)->first();
            if ($masterDoctor) {

                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            'id' => $masterDoctor?->id,
                            'first_name' => $masterDoctor?->first_name,
                            'dob' => $masterDoctor?->dob,
                            'gender' => $masterDoctor?->gender,
                            'mobile_no' => $masterDoctor?->contact_1,
                            'work_experience' => $masterDoctor?->doctorWorkMapping ? DoctorWorkExperienceResource::collection($masterDoctor?->doctorWorkMapping) : NULL
                        ]
                    ]
                );
            }
        }
    }
}
