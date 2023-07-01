<?php

namespace App\Http\Controllers;

use App\Models\DoctorSubCategoryMapping;
use App\Models\DoctorWorkExperienceMapping;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

            $user = $request->user();

            if ($user) {

                if ($request->has('mobile_no') && !is_null($request->mobile_no)) {
                    DB::transaction(function () use ($user, $request) {
                        $user->master_user_type_id = 2;
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->update();

                        $doctor = new MasterDoctor();
                        $doctor->user_id = $user->id;
                        $doctor->first_name = $request->name;
                        $doctor->dob = $request->dob;
                        $doctor->gender = $request->gender;
                        $doctor->address_line_1 = $request->address_line_1;
                        $doctor->city_id = $request->city_id;

                        $doctor->save();

                        return $this->sendLoginOtp($request->mobile_no);
                    });
                }

                // return response()->json(['status' => true, 'message' => 'Basic Details Added Successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found.']);
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
            'work' => 'required|array',
            'work.*.category_id' => 'required|integer',
            'work.*.sub_category_id' => 'required|string',
            'work.*.year_of_experience' => 'required|integer',
            'work.*.certificate.*' => 'sometimes|nullable|file|mimes:jpg,png,jpeg|max:5000',
            'work.*.description' => 'sometimes|required|string'

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
                            $doctorWorkMapping->category_id = $workData->category_id;
                            $doctorWorkMapping->sub_category_id = $workData->sub_category_id;
                            $doctorWorkMapping->year_of_experience = $workData->year_of_experience;
                            if ($workData->certificate) {
                                foreach ($workData->certificate as $certificates) {
                                    $doctorWorkMapping->addMedia($certificates)->toMediaCollection('doctor-certificate');
                                }
                            }

                            if ($workData->description) {
                                $doctorWorkMapping->description = $workData->description;
                            }

                            $workData->save();
                        }

                        return response()->json(['status' => true, 'message' => 'Work Experience Save Successfully']);
                    }

                } else {
                    return response()->json(['status' => false, 'message' => 'Doctor Data Not Found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found']);
            }
        }
    }
}
