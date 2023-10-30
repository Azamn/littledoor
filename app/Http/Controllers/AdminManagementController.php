<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use App\Models\MasterSkill;
use Illuminate\Support\Str;
use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use App\Models\MasterPatient;
use App\Models\MasterCategory;
use App\Models\MasterLanguage;
use App\Models\MasterQuestion;
use Illuminate\Support\Carbon;
use App\Models\MasterSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\LanguagesResource;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategoryQuestionMapping;
use App\Http\Resources\MasterSkillsResource;
use App\Http\Resources\MasterCategoryResource;
use App\Http\Resources\MasterSubCategoryResource;
use App\Http\Resources\QuestionWithOptionResource;

class AdminManagementController extends Controller
{

    public function login(Request $request)
    {

        $rules = [
            'mobile_no' => 'required|digits_between:10,10',
            'otp' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if ($request->has('mobile_no') && is_null($request->otp)) {

                $user = User::where('mobile_no', $request->mobile_no)->first();

                if ($user) {
                    // code to be added for deleting otp before sending if exists
                    return $this->sendLoginOtp($request->mobile_no);
                } else {

                    $apiToken = Str::random(60);
                    $rememberToken = Str::random(80);

                    $user = new User();
                    $user->master_user_type_id = 0;
                    $user->mobile_no = $request->mobile_no;
                    $user->api_token = $apiToken;
                    $user->remember_token = $rememberToken;
                    $user->save();

                    return $this->sendLoginOtp($request->mobile_no);
                }
            } elseif ($request->has('mobile_no') && ($request->has('otp') && !is_null($request->otp))) {

                $user = User::with('patient', 'doctor')->where('mobile_no', $request->mobile_no)->first();
                if ($user->master_user_type_id == 3 || $user->master_user_type_id == 4) {

                    $gender = null;
                    $dob = null;
                    $city = NULL;
                    $patientId = NULL;
                    if (!is_null($user->patient)) {
                        $patientId = $user?->patient?->id;
                        $gender = $user?->patient?->gender;
                        $dob = Carbon::parse($user?->patient?->dob)->format('d-m-Y');
                        $city = $user?->patient?->city_id;
                    }

                    $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();
                    if ($userOtp) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully Logged In!',
                            'api_token' => $user->api_token,
                            'is_patient' => 1,
                            'user_details' => [
                                'patient_id' => $patientId,
                                'name' => $user->name,
                                'email' => $user->email,
                                'gender' => $gender,
                                'dob' => $dob,
                                'city_id' => $city,

                            ],
                        ]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Otp Not Matched']);
                    }
                } elseif ($user->master_user_type_id == 2) { // doctor
                    $gender = null;
                    $dob = null;
                    $city = NULL;
                    $doctorId = NULL;
                    if (!is_null($user->doctor)) {
                        $doctorId = $user?->doctor?->id;
                        $gender = $user?->doctor?->gender;
                        $dob = Carbon::parse($user?->doctor?->dob)->format('d-m-Y');
                        $city = $user?->doctor?->city_id;
                    }

                    $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();
                    if ($userOtp) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully Logged In!',
                            'api_token' => $user->api_token,
                            'is_doctor' => 1,
                            'user_details' => [
                                'doctor_id' => $doctorId,
                                'name' => $user->name,
                                'email' => $user->email,
                                'gender' => $gender,
                                'dob' => $dob,
                                'city_id' => $city,

                            ],
                        ]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Otp Not Matched']);
                    }
                } else {
                    $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();
                    if ($userOtp) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully Logged In!',
                            'api_token' => $user->api_token,
                        ]);
                    } else {
                        return response()->json(['status' => false, 'User Not Found.']);
                    }
                }
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
                    $existOtp = (int)$existingOtps->otp;
                }
            }
            return response()->json(['status' => true, 'message' => 'Otp Sent Successfully', 'otp' => $existOtp]);
        } else {
            return response()->json(['status' => false, 'message' => 'Otp Not Sent']);
        }
    }

    public function getCategory(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $masterCategory = MasterCategory::with('media')->where('status', 1)->get();
            if ($masterCategory) {
                return response()->json(['status' => true, 'data' => MasterCategoryResource::collection($masterCategory)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Master Categories Not Found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

    public function getAllQuestionsWithOption(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $categoryQuestionMappingWithOptions = SubCategoryQuestionMapping::with('subCategory', 'question', 'optionMapping.option')->get();
            if ($categoryQuestionMappingWithOptions) {
                return response()->json(['status' => true, 'data' => QuestionWithOptionResource::collection($categoryQuestionMappingWithOptions)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Questions and options not found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

    public function getLanguages(Request $request)
    {

        $user = $request->user();

        if ($user) {
            $languages = MasterLanguage::where('status', 1)->get();
            if ($languages) {
                return response()->json(['statsu' => true, 'data' => LanguagesResource::collection($languages)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Languages not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User not authorized']);
        }
    }

    public function getSubCategory(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $subCategory = MasterSubCategory::where('master_category_id', $request->category_id)->where('status', 1)->get();
            if ($subCategory) {
                return response()->json(['status' => true, 'data' => MasterSubCategoryResource::collection($subCategory)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Not Found']);
            }
        }
    }

    public function getUserDetails(Request $request)
    {

        $user = $request->user();
        if ($user) {

            $addressProofData = NULL;
            $formStatus  = NULL;
            $doctorStatus = NULL;

            $pateint = MasterPatient::with('city')->where('user_id', $user->id)->first();
            if ($pateint) {
                $pateintId = $pateint->id;
                $gender = $pateint->gender;
                $dob = Carbon::parse($pateint->dob)->format('d-m-Y');
                $city = $pateint->city_id;
                $cityName = $pateint?->city?->city_name;
            }

            $doctor = MasterDoctor::with('media', 'doctorWorkMapping.media', 'doctorEducationMapping.media', 'doctorSkillsMapping', 'doctorAdressMapping', 'city')->where('user_id', $user->id)->first();
            if ($doctor) {

                $doctorId = $doctor->id;
                $gender = $doctor->gender;
                $dob = Carbon::parse($doctor->dob)->format('d-m-Y');
                $city = $doctor->city_id;
                $cityName = $doctor?->city?->city_name;
                $doctorStatus = $doctor->status;


                if ($doctor->media->isNotEmpty()) {
                    $addressProofData = $doctor->media->where('collection_name', 'doctor-address-proof')->last()->getFullUrl();
                }

                $formStatus = 0;
                if (!is_null($addressProofData) && !is_null($doctor->doctorWorkMapping) && !is_null($doctor->doctorEducationMapping) && !is_null($doctor->doctorSkillsMapping)) {
                    $formStatus = 1;
                }
            }

            if($user->media){
              $imageUrl =  $user->media->isNotEmpty() ? $user->media->last()->getFullUrl() : NULL;
            }else{
                $imageUrl = NULL;
            }

            $data = [
                'id' => $user->id,
                'pateint_id' => $pateintId ?? NULL,
                'doctor_id' => $doctorId ?? NULL,
                'status' => $doctorStatus,
                'form_status' => $formStatus,
                'name' => $user->name,
                'email' => $user->email,
                'mobile_no' => $user->mobile_no,
                'gender' => $gender ?? NULL,
                'dob' => $dob ?? NULL,
                'city_id' => $city ?? NULL,
                'city_name' => $cityName ?? NULL,
                'image_url' => $imageUrl ?? NULL

            ];

            return response()->json(['status' => true, 'data' => $data]);
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized User']);
        }
    }

    public function updateUserDetails(Request $request)
    {

        $rules = [
            'name' => 'sometimes|required',
            'email' => 'sometimes|required',
            'image' => 'sometimes|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                if ($request->has('name')) {
                    $user->name = $request->name;
                }

                if ($request->has('email')) {
                    $user->email = $request->email;
                }

                if ($request->has('image')) {
                    $user->addMediaFromRequest('image')->toMediaCollection('user-profile');
                }

                $user->update();

                return response()->json(['status' => true, 'message' => 'User Details Update Successfully.']);
            }
        }
    }

    public function getSkills(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $skills = MasterSkill::get();
            if ($skills->isNotEmpty()) {
                return response()->json(['status' => 'true', 'data' => MasterSkillsResource::collection($skills)]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized User']);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $newApiToken = Str::random(60);
            $user->api_token = $newApiToken;
            $user->remember_token = NULL;
            $user->update();
            return response()->json(['status' => true, 'message' => 'Logged Out Successfully !']);
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized User']);
        }
    }
}
