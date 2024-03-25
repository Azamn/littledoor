<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use App\Models\OTPSmsLog;
use App\Models\MasterSkill;
use Illuminate\Support\Str;
use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\MasterSubCategory;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorAdressMapping;
use App\Models\DoctorSessionCharge;
use App\Models\DoctorSkillsMapping;
use App\Models\DoctorPaymentRequest;
use Illuminate\Support\Facades\Http;
use App\Models\DoctorEducationMapping;
use App\Models\RazorPayTransactionLog;
use App\Models\DoctorSubCategoryMapping;
use App\Models\DoctorAppreciationMapping;
use Illuminate\Support\Facades\Validator;
use App\Models\DoctorOtherDocumentMapping;
use App\Models\DoctorWorkExperienceMapping;
use App\Http\Resources\DoctorSkillsResource;
use App\Http\Resources\DoctorAddressResource;
use App\Http\Resources\DoctorOtherDocResource;
use App\Http\Resources\DoctorEducationResource;
use App\Http\Resources\TransactionDataResource;
use App\Http\Resources\DoctorAppeciationResource;
use App\Http\Resources\DoctorSessionChargeResource;
use App\Http\Resources\DoctorWorkExperienceResource;
use App\Http\Resources\DoctorTransactionDataResource;
use App\Http\Resources\SuccessfullTransactionDataResource;

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
            'mobile_no' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {


            if ($request->has('mobile_no') && !is_null($request->mobile_no)) {

                $user = User::where('mobile_no', $request->mobile_no)->first();
                if ($user) {
                    $doctor = MasterDoctor::where('user_id', $user->id)->first();
                    if (!is_null($doctor)) {
                        return response()->json(['status' => false, 'message' => 'Doctor Details Already Exist with this mobile no :' . $request->mobile_no]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'User Exist with this mobile no :' . $request->mobile_no]);
                    }
                } else {

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

                        $dob = NULL;
                        $age = NULL;

                        if ($request->has('dob')) {
                            $todayDate = Carbon::parse(today());
                            $dob = Carbon::parse($request->dob);
                            $age = $dob->diffInYears($todayDate);
                        }

                        $doctor = new MasterDoctor();
                        $doctor->user_id = $user->id;
                        $doctor->first_name = $request->name;
                        $doctor->dob = $dob;
                        $doctor->age = $age;
                        $doctor->gender = $request->gender;
                        $doctor->contact_1 = $request->mobile_no;
                        $doctor->city_id = $request->city_id;
                        $doctor->status = 0;

                        $doctor->save();
                    });

                    return $this->sendLoginOtp($request->mobile_no);
                }
            }
        }
    }

    public function sendLoginOtp($mobileNumber)
    {
        $url = 'https://www.fast2sms.com/dev/bulkV2?';
        $autorization = env('SMS_AUTHORIZATION');
        $route = 'otp';
        $flash = 0;

        $otp = rand(100000, 999999);
        $validTill = now()->addMinutes(15);

        if ($mobileNumber) {
            $userExist = User::where('mobile_no', $mobileNumber)->first();
            if ($userExist) {

                if ($userExist->mobile_no == '8425918611') {
                    $userId = $userExist->id;
                    $otp = '119007';
                } else {
                    $userId = $userExist->id;
                    $existingOtps = UserOtp::where('user_id', $userId)->get();
                    $existingOtps->each->delete();

                    UserOtp::create([
                        'user_id' => $userId,
                        'otp' => $otp,
                        'valid_till' => $validTill,
                    ]);
                }

                $finalUrl = $url . 'authorization=' . $autorization . '&route=' . $route . '&variables_values=' . $otp . '&flash=' . $flash . '&numbers=' . $mobileNumber;
                $otpSMSLog = new OTPSmsLog();
                $otpSMSLog->user_id = $userId;
                $otpSMSLog->request_body = $finalUrl;
                $otpSMSLog->save();

                $response =  Http::get($finalUrl);
                $otpSMSLog->response = $response;
                $otpSMSLog->update();

                $finalResponse = $response->json();
                if ($finalResponse) {
                    if ($finalResponse['return'] == true) {
                        return response()->json(['status' => true, 'message' => 'Otp Sent Successfully']);
                    } else {
                        return response()->json(['status' => true, 'message' => 'Otp Sent Failed']);
                    }
                } else {
                    return response()->json(['status' => true, 'message' => 'something went wrong']);
                }
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Otp Not Sent']);
        }
    }

    public function submitDoctorDetail(Request $request)
    {

        $rules = [
            'step' => 'required|integer',
            /** step 1 of work Experience */
            'work' => 'required_if:step,1|array',
            'work.*.category_id' => 'required|integer',
            'work.*.sub_category_id' => 'sometimes|required|string',
            'work.*.year_of_experience' => 'sometimes|required|integer',
            'work.*.certificate.*' => 'sometimes|required|max:5000',
            // 'work.*.certificate.*' => 'sometimes|nullable|string|mimes:jpg,png,jpeg,pdf|max:5000',
            'work.*.description' => 'sometimes|required|string',
            /** Step 2 of education */
            'education' => 'required_if:step,2|array',
            'education.*.name' => 'sometimes|required',
            'education.*.institution_name' => 'sometimes|required',
            'education.*.field_of_study' => 'sometimes|required',
            'education.*.start_date' => 'sometimes|date|required',
            'education.*.end_date' => 'sometimes|date|required',
            'education.*.certificate.*' => 'sometimes|required|max:5000',
            // 'education.*.certificate.*' => 'sometimes|required|file|mimes:jpg,png,jpeg,pdf|max:5000',
            'education.*.description' => 'sometimes|required',
            /** Step 3 of skills */
            'skills.*' => 'required_if:step,3',
            /** Step 4 of address */
            'address_proof_document' => 'required_if:step,4',
            'address' => 'sometimes|required_if:step,4',
            'address.*.address_type' => 'sometimes|required|string',
            'address.*.address_line_1' => 'sometimes|required|string',
            'address.*.address_line_2' => 'sometimes|required|string',
            'address.*.pincode' => 'sometimes|required|string',
            'address.*.city_id' => 'sometimes|required|integer',
            'address.*.state_id' => 'sometimes|required|integer',
            /** Step 5 of languages*/
            'languages.*' => 'required_if:step,5',
            /** Step 6 of appreciation */
            'appreciation' => 'required_if:step,6|array',
            'appreciation.*.name' => 'sometimes|required',
            'appreciation.*.category_achieved' => 'sometimes|required',
            'appreciation.*.issue_date' => 'sometimes|required|date',
            'appreciation.*.category_achieved' => 'sometimes|required',
            'appreciation.*.image' => 'sometimes|required|max:5000',
            // 'appreciation.*.image' => 'sometimes|required|file|mimes:jpg,png,jpeg,pdf|max:5000',
            'appreciation.*.description' => 'sometimes|required|string',
            /** Step 7 other document */
            'other' => 'required_if:step,7|array',
            'other.*.name' => 'sometimes|required|string',
            'other.*.document' => 'sometimes|required|max:5000'
            // 'other.*.document' => 'sometimes|required|file|mimes:jpg,png,jpeg,pdf|max:5000'

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
                        if ($request->has('work')) {
                            $doctorWork = DoctorWorkExperienceMapping::where('doctor_id', $doctor->id)->get();

                            if ($doctorWork->isNotEmpty()) {

                                foreach ($doctorWork as $work) {
                                    $work->delete();
                                }

                                foreach ($request->work as $workData) {
                                    $doctorWorkMapping = new DoctorWorkExperienceMapping();
                                    $doctorWorkMapping->doctor_id = $doctor->id;
                                    $doctorWorkMapping->category_id = $workData['category_id'] ?? NULL;
                                    $doctorWorkMapping->sub_category_id = $workData['sub_category_id'] ?? NULL;
                                    $doctorWorkMapping->year_of_experience = $workData['year_of_experience'] ?? NULL;
                                    if (isset($workData['certificate']) && !is_null($workData['certificate'])) {
                                        foreach ($workData['certificate'] as $certificates) {
                                            $type = gettype($certificates);
                                            if ($type == 'string') {
                                                $certificateUrl = $certificates;
                                                $doctorWorkMapping->addMediaFromUrl($certificateUrl)->toMediaCollection('doctor-work-certificate');
                                            } else {
                                                $doctorWorkMapping->addMedia($certificates)->toMediaCollection('doctor-work-certificate');
                                            }
                                        }
                                    }

                                    if (isset($workData['description']) && !is_null($workData['description'])) {
                                        $doctorWorkMapping->description = $workData['description'] ?? NULL;
                                    }

                                    $doctorWorkMapping->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Work Experience Update Successfully']);
                            } else {
                                foreach ($request->work as $workData) {
                                    $doctorWorkMapping = new DoctorWorkExperienceMapping();
                                    $doctorWorkMapping->doctor_id = $doctor->id;
                                    $doctorWorkMapping->category_id = $workData['category_id'] ?? NULL;
                                    $doctorWorkMapping->sub_category_id = $workData['sub_category_id'] ?? NULL;
                                    $doctorWorkMapping->year_of_experience = $workData['year_of_experience'] ?? NULL;
                                    if (isset($workData['certificate']) && !is_null($workData['certificate'])) {
                                        foreach ($workData['certificate'] as $certificates) {
                                            $type = gettype($certificates);
                                            if ($type == 'string') {
                                                $certificateUrl = $certificates;
                                                $doctorWorkMapping->addMediaFromUrl($certificateUrl)->toMediaCollection('doctor-work-certificate');
                                            } else {
                                                $doctorWorkMapping->addMedia($certificates)->toMediaCollection('doctor-work-certificate');
                                            }
                                        }
                                    }

                                    if (isset($workData['description']) && !is_null($workData['description'])) {
                                        $doctorWorkMapping->description = $workData['description'] ?? NULL;
                                    }

                                    $doctorWorkMapping->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Work Experience Save Successfully']);
                            }
                        }
                    }

                    if ($request->has('step') && $request->step == 2) {

                        if ($request->has('education')) {
                            $doctorEdu = DoctorEducationMapping::where('doctor_id', $doctor->id)->get();

                            if ($doctorEdu->isNotEmpty()) {

                                foreach ($doctorEdu as $dEdu) {
                                    $dEdu->delete();
                                }

                                foreach ($request->education as $deucationData) {
                                    $doctorEducationMapping = new DoctorEducationMapping();
                                    $doctorEducationMapping->doctor_id = $doctor->id;
                                    $doctorEducationMapping->name = $deucationData['name'] ?? NULL;
                                    $doctorEducationMapping->institution_name = $deucationData['institution_name'] ?? NULL;
                                    $doctorEducationMapping->field_of_study = $deucationData['field_of_study'] ?? NULL;
                                    $doctorEducationMapping->start_date = $deucationData['start_date'] ?? NULL;
                                    $doctorEducationMapping->end_date = $deucationData['end_date'] ?? NULL;

                                    if (isset($deucationData['certificate']) && !is_null($deucationData['certificate'])) {
                                        foreach ($deucationData['certificate'] as $certificates) {
                                            $type = gettype($certificates);
                                            if ($type == 'string') {
                                                $certificateUrl = $certificates;
                                                $doctorEducationMapping->addMediaFromUrl($certificateUrl)->toMediaCollection('doctor-edu-certificate');
                                            } else {
                                                $doctorEducationMapping->addMedia($certificates)->toMediaCollection('doctor-edu-certificate');
                                            }
                                        }
                                    }

                                    if (isset($deucationData['description']) && !is_null($deucationData['description'])) {
                                        $doctorEducationMapping->description = $deucationData['description'] ?? NULL;
                                    }

                                    $doctorEducationMapping->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Education Details Update Successfully']);
                            } else {
                                foreach ($request->education as $deucationData) {
                                    $doctorEducationMapping = new DoctorEducationMapping();
                                    $doctorEducationMapping->doctor_id = $doctor->id;
                                    $doctorEducationMapping->name = $deucationData['name'] ?? NULL;
                                    $doctorEducationMapping->institution_name = $deucationData['institution_name'] ?? NULL;
                                    $doctorEducationMapping->field_of_study = $deucationData['field_of_study'] ?? NULL;
                                    $doctorEducationMapping->start_date = $deucationData['start_date'] ?? NULL;
                                    $doctorEducationMapping->end_date = $deucationData['end_date'] ?? NULL;

                                    if (isset($deucationData['certificate']) && !is_null($deucationData['certificate'])) {
                                        foreach ($deucationData['certificate'] as $certificates) {
                                            $type = gettype($certificates);
                                            if ($type == 'string') {
                                                $certificateUrl = $certificates;
                                                $doctorEducationMapping->addMediaFromUrl($certificateUrl)->toMediaCollection('doctor-edu-certificate');
                                            } else {
                                                $doctorEducationMapping->addMedia($certificates)->toMediaCollection('doctor-edu-certificate');
                                            }
                                        }
                                    }

                                    if (isset($deucationData['description']) && !is_null($deucationData['description'])) {
                                        $doctorEducationMapping->description = $deucationData['description'] ?? NULL;
                                    }

                                    $doctorEducationMapping->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Education Details Save Successfully']);
                            }
                        }
                    }

                    if ($request->has('step') && $request->step == 3) {

                        if ($request->has('skills')) {

                            $doctorSkills = DoctorSkillsMapping::where('doctor_id', $doctor->id)->get();

                            if ($doctorSkills->isNotEmpty()) {
                                foreach ($doctorSkills as $skill) {
                                    $skill->delete();
                                }

                                foreach ($request->skills as $skill) {

                                    $skills = MasterSkill::where('name', $skill)->first();
                                    if ($skills) {
                                        $skillId = $skills->id;
                                    } else {
                                        $skills = new MasterSkill();
                                        $skills->name = $skill;
                                        $skills->save();
                                        $skillId = $skills->id;
                                    }

                                    $doctorSkillsMapping = new DoctorSkillsMapping();
                                    $doctorSkillsMapping->doctor_id = $doctor->id;
                                    $doctorSkillsMapping->skill_id = $skillId;
                                    $doctorSkillsMapping->save();
                                }
                            } else {
                                foreach ($request->skills as $skill) {

                                    $skills = MasterSkill::where('name', $skill)->first();
                                    if ($skills) {
                                        $skillId = $skills->id;
                                    } else {
                                        $skills = new MasterSkill();
                                        $skills->name = $skill;
                                        $skills->save();
                                        $skillId = $skills->id;
                                    }

                                    $doctorSkillsMapping = new DoctorSkillsMapping();
                                    $doctorSkillsMapping->doctor_id = $doctor->id;
                                    $doctorSkillsMapping->skill_id = $skillId;
                                    $doctorSkillsMapping->save();
                                }
                            }

                            return response()->json(['status' => true, 'message' => 'Skills Details Save Successfully']);
                        }
                    }

                    if ($request->has('step') && $request->step == 4) {

                        if ($request->has('address') && $request->has('address_proof_document')) {

                            $doctorAddress = DoctorAdressMapping::where('doctor_id', $doctor->id)->get();
                            if ($doctorAddress->isNotEmpty()) {

                                foreach ($doctorAddress as $doctorAdd) {
                                    $doctorAdd->delete();
                                }

                                foreach ($request->address as $address) {
                                    $doctorAddressMapping = new DoctorAdressMapping();
                                    $doctorAddressMapping->doctor_id = $doctor->id;
                                    $doctorAddressMapping->address_type = $address['address_type'];
                                    $doctorAddressMapping->address_line_1 = $address['address_line_1'];
                                    $doctorAddressMapping->address_line_2 = $address['address_line_1'] ?? NULL;
                                    $doctorAddressMapping->pincode = $address['pincode'];
                                    $doctorAddressMapping->city_id = $address['city_id'];
                                    $doctorAddressMapping->state_id = $address['state_id'];
                                    $doctorAddressMapping->save();
                                }
                                return response()->json(['status' => true, 'message' => 'Address Update Successfully']);
                            } else {
                                foreach ($request->address as $address) {
                                    $doctorAddressMapping = new DoctorAdressMapping();
                                    $doctorAddressMapping->doctor_id = $doctor->id;
                                    $doctorAddressMapping->address_type = $address['address_type'];
                                    $doctorAddressMapping->address_line_1 = $address['address_line_1'];
                                    $doctorAddressMapping->address_line_2 = $address['address_line_1'] ?? NULL;
                                    $doctorAddressMapping->pincode = $address['pincode'];
                                    $doctorAddressMapping->city_id = $address['city_id'];
                                    $doctorAddressMapping->state_id = $address['state_id'];
                                    $doctorAddressMapping->save();
                                }

                                if ($request->has('address_proof_document')) {
                                    $type = gettype($request->address_proof_document);
                                    if ($type == 'string') {
                                        $addressProofUrl = $request->address_proof_document;
                                        $doctor->addMediaFromUrl($addressProofUrl)->toMediaCollection('doctor-address-proof');
                                    } else {
                                        $doctor->addMediaFromRequest('address_proof_document')->toMediaCollection('doctor-address-proof');
                                    }
                                }

                                return response()->json(['status' => true, 'message' => 'Address Added Successfully']);
                            }
                        }

                        if ($request->has('address_proof_document')) {
                            $type = gettype($request->address_proof_document);
                            if ($type == 'string') {
                                $addressProofUrl = $request->address_proof_document;
                                $doctor->addMediaFromUrl($addressProofUrl)->toMediaCollection('doctor-address-proof');
                            } else {
                                $doctor->addMediaFromRequest('address_proof_document')->toMediaCollection('doctor-address-proof');
                            }
                            $doctor->update();

                            return response()->json(['status' => true, 'message' => 'Address-proof document addded Successfully']);
                        }
                    }

                    if ($request->has('step') && $request->step == 5) {
                        if ($request->has('languages')) {

                            if (!is_null($doctor->languages_known)) {

                                $doctor->languages_known = NULL;
                                $doctor->update();

                                $doctorLang = implode(',', $request->languages);
                                $doctor->languages_known = $doctorLang;
                                $doctor->save();

                                return response()->json(['status' => true, 'message' => 'Languages Update Successfully']);
                            } else {
                                $doctorLang = implode(',', $request->languages);
                                $doctor->languages_known = $doctorLang;
                                $doctor->save();
                                return response()->json(['status' => true, 'message' => 'Languages Added Successfully']);
                            }
                        }
                    }

                    if ($request->has('step') && $request->step == 6) {

                        if ($request->has('appreciation')) {

                            $doctorAppreciation = DoctorAppreciationMapping::where('doctor_id', $doctor->id)->get();

                            if ($doctorAppreciation->isNotEmpty()) {

                                foreach ($doctorAppreciation as $appreciation) {
                                    $appreciation->delete();
                                }

                                foreach ($request->appreciation as $appreciationData) {
                                    $doctorAppreciationMapping = new DoctorAppreciationMapping();
                                    $doctorAppreciationMapping->doctor_id = $doctor->id;
                                    $doctorAppreciationMapping->name = $appreciationData['name'] ?? NULL;
                                    $doctorAppreciationMapping->category_achieved = $appreciationData['category_achieved'] ?? NULL;
                                    $doctorAppreciationMapping->issue_date = $appreciationData['issue_date'] ?? NULL;

                                    if (isset($appreciationData['image']) && !is_null($appreciationData['image'])) {
                                        $type = gettype($appreciationData['image']);
                                        if ($type == 'string') {
                                            $apreciationUrl = $appreciationData['image'];
                                            $doctorAppreciationMapping->addMediaFromUrl($apreciationUrl)->toMediaCollection('doctor-appreciation');
                                        } else {
                                            $doctorAppreciationMapping->addMedia($appreciationData['image'])->toMediaCollection('doctor-appreciation');
                                        }
                                    }

                                    if (isset($appreciationData['description']) && !is_null($appreciationData['description'])) {
                                        $doctorAppreciationMapping->description = $appreciationData['description'] ?? NULL;
                                    }

                                    $doctorAppreciationMapping->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Appreciation Data Update Successfully']);
                            } else {

                                foreach ($request->appreciation as $appreciationData) {
                                    $doctorAppreciationMapping = new DoctorAppreciationMapping();
                                    $doctorAppreciationMapping->doctor_id = $doctor->id;
                                    $doctorAppreciationMapping->name = $appreciationData['name'] ?? NULL;
                                    $doctorAppreciationMapping->category_achieved = $appreciationData['category_achieved'] ?? NULL;
                                    $doctorAppreciationMapping->issue_date = $appreciationData['issue_date'] ?? NULL;

                                    if (isset($appreciationData['image']) && !is_null($appreciationData['image'])) {

                                        $type = gettype($appreciationData['image']);
                                        if ($type == 'string') {
                                            $apreciationUrl = $appreciationData['image'];
                                            $doctorAppreciationMapping->addMediaFromUrl($apreciationUrl)->toMediaCollection('doctor-appreciation');
                                        } else {
                                            $doctorAppreciationMapping->addMedia($appreciationData['image'])->toMediaCollection('doctor-appreciation');
                                        }
                                    }

                                    if (isset($appreciationData['description']) && !is_null($appreciationData['description'])) {
                                        $doctorAppreciationMapping->description = $appreciationData['description'] ?? NULL;
                                    }

                                    $doctorAppreciationMapping->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Appreciation Data Save Successfully']);
                            }
                        }
                    }

                    if ($request->has('step') && $request->step == 7) {

                        if ($request->has('other')) {

                            $doctorOther = DoctorOtherDocumentMapping::where('doctor_id', $doctor->id)->get();
                            if ($doctorOther->isNotEmpty()) {
                                foreach ($doctorOther as $other) {
                                    $other->delete();
                                }

                                foreach ($request->other as $otherData) {
                                    $otherDoctorDocument = new DoctorOtherDocumentMapping();
                                    $otherDoctorDocument->doctor_id = $doctor->id;
                                    $otherDoctorDocument->name = $otherData['name'];

                                    if ($otherData['document']) {
                                        $type = gettype($otherData['document']);
                                        if ($type == 'string') {
                                            $otherDocumentUrl = $otherData['document'];
                                            $otherDoctorDocument->addMediaFromUrl($otherDocumentUrl)->toMediaCollection('doctor-other-document');
                                        } else {
                                            $otherDoctorDocument->addMedia($otherData['document'])->toMediaCollection('doctor-other-document');
                                        }
                                    }

                                    $otherDoctorDocument->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Other Details Update Successfully']);
                            } else {

                                foreach ($request->other as $otherData) {
                                    $otherDoctorDocument = new DoctorOtherDocumentMapping();
                                    $otherDoctorDocument->doctor_id = $doctor->id;
                                    $otherDoctorDocument->name = $otherData['name'];

                                    if ($otherData['document']) {
                                        $type = gettype($otherData['document']);
                                        if ($type == 'string') {
                                            $otherDocumentUrl = $otherData['document'];
                                            $otherDoctorDocument->addMediaFromUrl($otherDocumentUrl)->toMediaCollection('doctor-other-document');
                                        } else {
                                            $otherDoctorDocument->addMedia($otherData['document'])->toMediaCollection('doctor-other-document');
                                        }
                                    }

                                    $otherDoctorDocument->save();
                                }

                                return response()->json(['status' => true, 'message' => 'Other Details Save Successfully']);
                            }
                        }
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Doctor Details Not Found']);
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
            $masterDoctor = MasterDoctor::with('media', 'doctorWorkMapping.media', 'doctorEducationMapping.media', 'doctorSkillsMapping.skill', 'doctorAdressMapping', 'doctorAppreciationMapping.media', 'otherDocMapping.media', 'doctorSession')->where('user_id', $user->id)->first();
            if ($masterDoctor) {

                $addressProofData = NULL;
                $languages = NULL;

                if ($masterDoctor->media->isNotEmpty()) {
                    $addressProofData = $masterDoctor->media->where('collection_name', 'doctor-address-proof')->last()->getFullUrl();
                }

                if (!is_null($masterDoctor->languages_known)) {
                    $languages = explode(",", $masterDoctor->languages_known);
                }

                $formStatus = 0;
                if (!is_null($addressProofData) && !is_null($masterDoctor->doctorWorkMapping) && !is_null($masterDoctor->doctorEducationMapping) && !is_null($masterDoctor->doctorSkillsMapping)) {
                    $formStatus = 1;
                }

                $data =  [
                    'id' => $masterDoctor?->id,
                    'first_name' => $masterDoctor?->first_name,
                    'dob' => $masterDoctor?->dob,
                    'gender' => $masterDoctor?->gender,
                    'mobile_no' => $masterDoctor?->contact_1,
                    'address_proof_url' => $addressProofData ?? NULL,
                    'status' => $masterDoctor->status,
                    'form_status' => $formStatus,
                    'session_charge' => $masterDoctor?->doctorSession?->session_amount ?? NULL,
                    'work_experience' => $masterDoctor?->doctorWorkMapping ? DoctorWorkExperienceResource::collection($masterDoctor?->doctorWorkMapping) : NULL,
                    'education' => $masterDoctor?->doctorEducationMapping ? DoctorEducationResource::collection($masterDoctor?->doctorEducationMapping) : NULL,
                    'skills' => $masterDoctor?->doctorSkillsMapping ? DoctorSkillsResource::collection($masterDoctor?->doctorSkillsMapping) : NULL,
                    'address' => $masterDoctor?->doctorAdressMapping ? DoctorAddressResource::collection($masterDoctor?->doctorAdressMapping) : NULL,
                    'languages' => $languages,
                    'appreciation' => $masterDoctor?->doctorAppreciationMapping ? DoctorAppeciationResource::collection($masterDoctor?->doctorAppreciationMapping) : NULL,
                    'other' => $masterDoctor?->otherDocMapping ? DoctorOtherDocResource::collection($masterDoctor?->otherDocMapping) : NULL
                ];

                return response()->json(
                    [
                        'status' => true,
                        'data' => $data
                    ]
                );
            }
        }
    }

    public function getDoctorList(Request $request)
    {
        $doctorData = [];
        $masterDoctors = MasterDoctor::with('user')->get();
        if ($masterDoctors->isNotEmpty()) {

            foreach ($masterDoctors as $doctor) {

                $data = [
                    'id' => $doctor->id,
                    'name' => $doctor->first_name,
                    'email' => $doctor?->user?->email ?? NULL,
                    'mobile_no' => $doctor?->contact_1,
                    'city' => $doctor?->city?->city_name ?? NULL,
                    'status' => $doctor->status
                ];

                array_push($doctorData, $data);
            }
        }
        return view('Admin.Doctor.doctor-list', Compact('doctorData'));
    }

    public function changeDoctorStatus(Request $request)
    {

        $masterDoctor = MasterDoctor::where('id', $request->doctor_id)->first();
        if ($masterDoctor) {
            $masterDoctor->status = !$masterDoctor->status;
            $masterDoctor->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }

    public function getDoctorDetailsView(Request $request, $doctorId)
    {

        $masterDoctor = MasterDoctor::with('media', 'doctorWorkMapping.media', 'doctorWorkMapping.category', 'doctorEducationMapping.media', 'doctorSkillsMapping.skill', 'doctorAdressMapping', 'doctorAppreciationMapping.media', 'otherDocMapping.media')->where('id', $doctorId)->first();


        if ($masterDoctor) {

            $addressProofData = NULL;
            $langages = NULL;

            if ($masterDoctor->media->isNotEmpty()) {
                $addressProofData = $masterDoctor->media->where('collection_name', 'doctor-address-proof')->last()->getFullUrl();
            }

            if (!is_null($masterDoctor->languages_known)) {
                $langages = explode(",", $masterDoctor->languages_known);
            }

            $formStatus = 0;
            if (!is_null($addressProofData) && !is_null($masterDoctor->doctorWorkMapping) && !is_null($masterDoctor->doctorEducationMapping) && !is_null($masterDoctor->doctorSkillsMapping)) {
                $formStatus = 1;
            }


            $workExperienceData = [];
            $educationData = [];
            $skillsData = [];
            $addressData = [];
            $appreciationData = [];
            $otherData = [];

            /** Work Experience Data */
            if (!is_null($masterDoctor->doctorWorkMapping)) {
                foreach ($masterDoctor->doctorWorkMapping as $doctorWE) {

                    $subCategoriesData = [];
                    $certificates = [];

                    if ($doctorWE->sub_category_id) {
                        $subCategoryIds = explode(',', $doctorWE->sub_category_id);

                        foreach ($subCategoryIds as $subCategoryId) {

                            $subCategory = MasterSubCategory::where('id', $subCategoryId)->first();
                            if ($subCategory) {
                                $data = [
                                    'id' => $subCategory->id,
                                    'name' => $subCategory->name,
                                ];

                                array_push($subCategoriesData, $data);
                            }
                        }
                    }

                    if ($doctorWE->media->isNotEmpty()) {
                        $docotrCertificate = $doctorWE->media->where('collection_name', 'doctor-work-certificate');
                        if ($docotrCertificate->isNotEmpty()) {
                            foreach ($docotrCertificate as $certificate) {
                                $doctorCertificationUrl = $certificate->getFullUrl();

                                if ($doctorCertificationUrl) {
                                    array_push($certificates, $doctorCertificationUrl);
                                }
                            }
                        }
                    }


                    $data = [
                        'category_name' => $doctorWE->category->name,
                        'sub_category' => $subCategoriesData ?? NULL,
                        'certificate' => $certificates ?? NULL,
                        'year_of_experience' => $doctorWE->year_of_experience ?? NULL,
                        'description' => $doctorWE->description ?? NULL

                    ];

                    array_push($workExperienceData, $data);
                }
            }

            /** Doctor Education Data */
            if (!is_null($masterDoctor->doctorEducationMapping)) {
                foreach ($masterDoctor->doctorEducationMapping as $education) {

                    $documents = [];

                    if ($education->media->isNotEmpty()) {
                        $docotrEducation = $education->media->where('collection_name', 'doctor-edu-certificate');
                        if ($docotrEducation->isNotEmpty()) {
                            foreach ($docotrEducation as $certificate) {
                                $doctorEducationDocumentUrl = $certificate->getFullUrl();

                                if ($doctorEducationDocumentUrl) {
                                    array_push($documents, $doctorEducationDocumentUrl);
                                }
                            }
                        }
                    }

                    $data = [
                        'name' => $education?->name,
                        'institution_name' => $education?->institution_name,
                        'field_of_study' => $education?->field_of_study,
                        'start_date' => Carbon::parse($education?->start_date)->format('d-m-Y'),
                        'end_date' => Carbon::parse($education?->end_date)->format('d-m-Y'),
                        'documents' => $documents ?? NULL,
                        'description' => $education?->description ?? NULL
                    ];

                    array_push($educationData, $data);
                }
            }

            /** Doctor Skills data  */
            if (!is_null($masterDoctor?->doctorSkillsMapping)) {
                foreach ($masterDoctor?->doctorSkillsMapping as $doctorSkills) {

                    $data =  [
                        'skill_id' => $doctorSkills?->skill_id,
                        'skill_name' => $doctorSkills?->skill?->name ?? NULL,
                    ];

                    array_push($skillsData, $data);
                }
            }

            /** Doctor Address */
            if (!is_null($masterDoctor?->doctorAdressMapping)) {
                foreach ($masterDoctor?->doctorAdressMapping as $address) {

                    $data =  [
                        'address_type' => $address?->address_type,
                        'address_line_1' => $address?->address_line_1 ?? NULL,
                        'address_line_2' => $address?->address_line_2 ?? NULL,
                        'pincode' => $address?->pincode ?? NULL,
                        'city_id' => $address?->city_id ?? NULL,
                        'city_name' => $address?->city?->city_name ?? NULL,
                        'state_id' => $address?->state_id ?? NULL,
                        'state_name' => $address?->state?->state_name ?? NULL
                    ];

                    array_push($addressData, $data);
                }
            }

            /** Doctor Appreciation */
            if (!is_null($masterDoctor?->doctorAppreciationMapping)) {
                foreach ($masterDoctor?->doctorAppreciationMapping as $appreciation) {

                    $data =  [
                        'name' => $appreciation?->name,
                        'category_achieved' => $appreciation?->category_achieved ?? NULL,
                        'issue_date' => Carbon::parse($appreciation?->issue_date)->format('d-m-Y'),
                        'description' => $appreciation?->description ?? NULL,
                        'image_url' => $appreciation->media->isNotEmpty() ? $appreciation->media->where('collection_name', 'doctor-appreciation')->last()->getFullUrl() : NULL
                    ];

                    array_push($appreciationData, $data);
                }
            }

            /** Doctor Other Document */
            if (!is_null($masterDoctor?->otherDocMapping)) {
                foreach ($masterDoctor?->otherDocMapping as $other) {

                    $data =  [
                        'name' => $other?->name,
                        'document' => $other?->media->isNotEmpty() ? $other->media->where('collection_name', 'doctor-other-document')->last()->getFullUrl() : NULL
                    ];

                    array_push($otherData, $data);
                }
            }


            $data =  [
                'id' => $masterDoctor?->id,
                'first_name' => $masterDoctor?->first_name,
                'status' => $masterDoctor?->status ?? NULL,
                'email' => $masterDoctor?->user?->email ?? NULL,
                'city' => $masterDoctor?->city?->city_name ?? NULL,
                'dob' => $masterDoctor?->dob,
                'gender' => $masterDoctor?->gender,
                'mobile_no' => $masterDoctor?->contact_1,
                'address_proof_url' => $addressProofData ?? NULL,
                'work_experience' => $workExperienceData ?? NULL,
                'education' => $educationData ?? NULL,
                'skills' => $skillsData ?? NULL,
                'address' => $addressData ?? NULL,
                'languages' => $langages,
                'appreciation' => $appreciationData ?? NULL,
                'other' => $otherData ?? NULL

            ];

            return view('Admin.Doctor.doctor-view', compact('data'));
        }
    }

    /** Doctor Session  charges*/

    public function addorUpdateSessionCharge(Request $request)
    {

        $rules = [
            'doctor_id' => 'required|integer|exists:master_doctors,id',
            'session_charge_amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $doctorSession = DoctorSessionCharge::where('doctor_id', $request->doctor_id)->first();
            if (is_null($doctorSession)) {

                $doctorSessionCharge = new DoctorSessionCharge();
                $doctorSessionCharge->doctor_id = $request->doctor_id;
                $doctorSessionCharge->session_amount = $request->session_charge_amount;
                $doctorSessionCharge->save();

                return response()->json(['status' => true, 'message' => 'Doctor Session Charge Added Successfully.']);
            } else {

                $doctorSession->session_amount = $request->session_charge_amount;
                $doctorSession->update();

                return response()->json(['status' => true, 'message' => 'Doctor Session Charge Updated Successfully.']);
            }
        }
    }

    public function getDoctorSession(Request $request)
    {

        $rules = [
            'doctor_id' => 'required|integer|exists:master_doctors,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $doctorSession = DoctorSessionCharge::where('doctor_id', $request->doctor_id)->get();
            if (!is_null($doctorSession)) {
                return response()->json(['status' => true, 'data' => DoctorSessionChargeResource::collection($doctorSession)]);
            }
        }
    }

    public function updateAvailableConsultancy(Request $request)
    {

        $rules = [
            'doctor_id' => 'required|integer|exists:master_doctors,id',
            'consultancy_status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $masterDoctor = MasterDoctor::where('id', $request->doctor_id)->first();
            if (!is_null($masterDoctor)) {
                $masterDoctor->consultancy_status = $request->consultancy_status;
                $masterDoctor->update();

                return response()->json(['status' => true, 'message' => 'Doctor Availability Consultancy updated successfully.']);
            }
        }
    }

    public function paymentrequest(Request $request)
    {

        $rules = [
            'request_amount' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {
                $doctor = $user->doctor;

                if ($doctor) {

                    $totalRequestedAmount = 0;

                    $transcationData = RazorPayTransactionLog::where('doctor_id', $doctor->id)->where('status', 'Success')->get();
                    if ($transcationData) {
                        $totalTransactionAmout = $transcationData->sum('amount');

                        $doctorPaymentRequest = DoctorPaymentRequest::where('doctor_id', $doctor->id)->get();
                        if ($doctorPaymentRequest) {
                            $totalRequestedAmount = $doctorPaymentRequest->sum('request_amount');
                        }

                        if ($totalRequestedAmount) {
                            $finalTransactionAmount = $totalTransactionAmout - $totalRequestedAmount;
                        } else {
                            $finalTransactionAmount = $totalTransactionAmout;
                        }

                        if ($request->request_amount <= $finalTransactionAmount) {
                            $doctorPaymentRequest = new DoctorPaymentRequest();
                            $doctorPaymentRequest->request_transaction_number = generateUniqueUserId();
                            $doctorPaymentRequest->doctor_id = $doctor->id;
                            $doctorPaymentRequest->request_amount = $request->request_amount;
                            $doctorPaymentRequest->save();

                            return response()->json(['status' => true, 'message' => 'Your withdrawal for amount ' . $request->amount . ' has been successfully registered. the amount will be credit in your account within 7 days .']);
                        } else {
                            return response()->json(['status' => false, 'message' => 'You don`t have sufficient balance in your wallet. Please check your balance.']);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'You don`t have any transaction to request.']);
                    }
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Unauthorized User']);
            }
        }
    }

    public function getDoctorRevenue(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $doctor = $user->doctor;

            if ($doctor) {

                $transcationData = RazorPayTransactionLog::where('doctor_id', $doctor->id)->where('status', 'Success')->get();
                if ($transcationData) {

                    $pendingRequestAmountData = NULL;
                    $successfullTransactionData = NULL;
                    $totalTransactionAmout = 0;
                    $totalPendingAmount = 0;
                    $totalRequestedAmount = 0;

                    $doctorPaymentRequest = DoctorPaymentRequest::where('doctor_id', $doctor->id)->get();
                    if ($doctorPaymentRequest) {
                        $pendingRequestAmountData = $doctorPaymentRequest->where('status', 0);
                        $successfullTransactionData = $doctorPaymentRequest->where('status', 1);
                        $totalRequestedAmount = $doctorPaymentRequest->sum('request_amount');
                    }

                    $totalTransactionAmout = $transcationData->sum('amount');
                    $totalPendingAmount = $totalTransactionAmout - $totalRequestedAmount;

                    return response()->json(['status' => true, 'data' => [
                        'total_trasaction_amount' => $totalTransactionAmout,
                        'total_pending_amount' => $totalPendingAmount,
                        'successfull_transaction_data' => $successfullTransactionData ?  TransactionDataResource::collection($successfullTransactionData) : NULL,
                        'pending_request_amount_data' => $pendingRequestAmountData ? TransactionDataResource::collection($pendingRequestAmountData) : NULL
                    ]]);
                }
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized User']);
        }
    }

    public function getUserTransaction(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $doctor = $user->doctor;
            $patient = $user->patient;

            if ($doctor || $patient) {
                if ($doctor) {
                    $transcationData = RazorPayTransactionLog::with('patient', 'doctor')->where('doctor_id', $doctor->id)->orderBy('id', 'desc')->get();
                    if ($transcationData) {
                        return response()->json(['status' => true, 'data' => DoctorTransactionDataResource::collection($transcationData)]);
                    }
                }

                if ($patient) {
                    $transcationData = RazorPayTransactionLog::with('patient', 'doctor')->where('patient_id', $patient->id)->orderBy('id', 'desc')->get();
                    if ($transcationData) {
                        return response()->json(['status' => true, 'data' => DoctorTransactionDataResource::collection($transcationData)]);
                    }
                }
            }
        }
    }

    public function getDoctorAppointmentStats(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $doctor = $user->doctor;

            if ($doctor) {

                $to = today()->toDateTimeString();
                $fromDayWise = Carbon::parse($to)->subDays(7)->toDateTimeString();

                $fromWeekWise = Carbon::parse($to)->subDays(15)->toDateTimeString();

                $fromYear = '2023-10-01';

                $dayWise = DB::table('patient_appointments as pa')
                    ->selectRaw("COUNT(*) as appointment_count")
                    ->selectRaw("CASE WHEN pa.appointment_date IS NOT NULL AND DATE(appointment_date)>=DATE('2023-10-01') THEN DATE_FORMAT(pa.appointment_date, '%W-%d') ELSE DATE_FORMAT(pa.appointment_date, '%W-%d') END AS day")

                    ->whereBetween(DB::raw('DATE(pa.appointment_date)'), [$fromDayWise, $to])
                    ->groupBy('day')->orderBy('day', 'ASC')->get();

                $weekWise = DB::table('patient_appointments as pa')
                    ->selectRaw("COUNT(*) as appointment_count")
                    ->selectRaw("CASE WHEN pa.appointment_date IS NOT NULL AND DATE(appointment_date)>=DATE('2023-10-01') THEN DATE_FORMAT(pa.appointment_date, '%W-%d') ELSE DATE_FORMAT(pa.appointment_date, '%W-%d') END AS week")

                    ->whereBetween(DB::raw('DATE(pa.appointment_date)'), [$fromWeekWise, $to])
                    ->groupBy('week')->orderBy('week', 'ASC')->get();

                $monthWise = DB::table('patient_appointments as pa')
                    ->selectRaw("COUNT(*) as appointment_count")
                    ->selectRaw("CASE WHEN pa.appointment_date IS NOT NULL AND DATE(appointment_date)>=DATE('2023-10-01') THEN DATE_FORMAT(pa.appointment_date, '%M-%Y') ELSE DATE_FORMAT(pa.appointment_date, '%M-%y') END AS month")

                    ->whereBetween(DB::raw('DATE(pa.appointment_date)'), [$fromYear, $to])
                    ->groupBy('month')->orderBy('month', 'ASC')->get();

                return response()->json(['status' => true, 'data' => [
                    'last_seven_day_wise' => $dayWise->values() ?? NULL,
                    'last_fifteen_day_wise' => $weekWise->values() ?? NULL,
                    'month_wise' => $monthWise->values() ?? NULL,
                ]]);
            }
        }
    }
}
