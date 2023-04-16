<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MasterQuestion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\QuestionWithOptionResource;

class AdminManagementController extends Controller
{

    public function login(Request $request)
    {

        $rules = [
            'mobile_no' => 'required|digits_between:10,10',
            'otp' => 'sometimes|required',
            'is_patient' => 'sometimes|required',
            'is_doctor' => 'sometimes|required',
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

                    if ($request->has('is_patient')) {
                        $masterUserTypeId = 3;
                    } elseif ($request->has('is_doctor')) {
                        $masterUserTypeId = 2;
                    }

                    $user = new User();
                    $user->master_user_type_id = $masterUserTypeId;
                    $user->mobile_no = $request->mobile_no;
                    $user->api_token = $apiToken;
                    $user->remember_token = $rememberToken;
                    $user->save();

                    return $this->sendLoginOtp($request->mobile_no);
                }
            } elseif ($request->has('mobile_no') && ($request->has('otp') && !is_null($request->otp))) {

                $user = User::with('patient')->where('mobile_no', $request->mobile_no)->first();
                if ($user) {

                    $gender = null;
                    $dob = null;
                    $city = NULL;
                    if (!is_null($user->patient)) {
                        $gender = $user->patient->gender;
                        $dob = Carbon::parse($user->patient->dob)->format('d-m-Y');
                        $city = $user->patient->city_id;
                    }

                    $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();
                    if ($userOtp) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully Logged In!',
                            'api_token' => $user->api_token,
                            'basic_details' => [
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
                }else{
                    $existOtp = $existingOtps->otp;
                }
            }
            return response()->json(['status' => true, 'message' => 'Otp Sent Successfully', 'otp' => $existOtp]);
        } else {
            return response()->json(['status' => false, 'message' => 'Otp Not Sent']);
        }
    }

    public function getAllQuestionsWithOption(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $questionWithOptions = MasterQuestion::with('subCategoryQuestionOption.options')->where('status', 1)->get();
            if ($questionWithOptions) {

                return response()->json(['status' => true, 'data' => QuestionWithOptionResource::collection($questionWithOptions)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Questions and options not found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

}
