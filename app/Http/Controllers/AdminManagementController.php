<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MasterCategory;
use App\Models\MasterQuestion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategoryQuestionMapping;
use App\Http\Resources\MasterCategoryResource;
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
                    if (!is_null($user->patient)) {
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
                            'patient_details' => [
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
                    if (!is_null($user->doctor)) {
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
                            'doctor_details' => [
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
                    return response()->json(['status' => false, 'User Not Found.']);
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
                    $existOtp = $existingOtps->otp;
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
}
