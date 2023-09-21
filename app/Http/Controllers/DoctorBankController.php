<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorBankDetail;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DoctorBankDetailsResource;

class DoctorBankController extends Controller
{

    public function createUpdateBankDetails(Request $request)
    {

        $rules = [
            'account_type' => 'required|string',
            'account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'ifsc_code' => 'required|string',
            'branch_name' => 'required|string',
            'documents' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $doctor = $user->doctor;

                if ($doctor) {

                    $bankDetailsAvailable = DoctorBankDetail::where('doctor_id', $doctor->id)->first();

                    if ($bankDetailsAvailable) {

                        if ($request->has('account_type')) {
                            $bankDetailsAvailable->account_type = $request->account_type;
                        }

                        if ($request->has('account_number')) {
                            $bankDetailsAvailable->account_number = $request->account_number;
                        }

                        if ($request->has('account_holder_name')) {
                            $bankDetailsAvailable->account_holder_name = $request->account_holder_name;
                        }

                        if ($request->has('ifsc_code')) {
                            $bankDetailsAvailable->ifsc_code = $request->ifsc_code;
                        }

                        if ($request->has('branch_name')) {
                            $bankDetailsAvailable->branch_name = $request->branch_name;
                        }

                        if ($request->has('documents')) {
                            $bankDetailsAvailable->addMediaFromRequest('documents')->toMediaCollection('bank-passbook');
                        }

                        $bankDetailsAvailable->update();

                        return response()->json(['status' => true, 'message' => 'Bank Details Updated Successfully.']);
                    } else {
                        $doctorBankDetails = new DoctorBankDetail();
                        $doctorBankDetails->doctor_id = $doctor->id;
                        $doctorBankDetails->account_type = $request->account_type;
                        $doctorBankDetails->account_number = $request->account_number;
                        $doctorBankDetails->account_holder_name = $request->account_holder_name;
                        $doctorBankDetails->ifsc_code = $request->ifsc_code;
                        $doctorBankDetails->branch_name = $request->branch_name;
                        $doctorBankDetails->save();

                        if ($request->has('documents')) {
                            $doctorBankDetails->addMediaFromRequest('documents')->toMediaCollection('bank-passbook');
                        }

                        return response()->json(['status' => true, 'message' => 'Bank Details Save Successfully.']);
                    }
                }
            }
        }
    }

    public function getBankDetails(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $doctor = $user->doctor;

            if ($doctor) {

                $doctorBankDetails = DoctorBankDetail::with('media')->where('doctor_id', $doctor->id)->get();
                if ($doctorBankDetails) {
                    return response()->json(['status' => true, 'data' => DoctorBankDetailsResource::collection($doctorBankDetails)]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Bank Details Not Found']);
                }
            }
        }
    }

    public function deleteBankDetails(Request $request, $bankDetailsId)
    {

        $user = $request->user();

        if ($user) {

            $doctor = $user->doctor;

            if ($doctor) {

                $doctorBankDetails = DoctorBankDetail::where('id', $bankDetailsId)->first();
                if ($doctorBankDetails) {
                    $doctorBankDetails->delete();

                    return response()->json(['status' => true, 'message' => 'Bank Details Deleted Successfully.']);
                }
            }
        }
    }
}
