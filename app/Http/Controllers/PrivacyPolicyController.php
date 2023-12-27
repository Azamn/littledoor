<?php

namespace App\Http\Controllers;

use App\Models\Privacypolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends Controller
{

    public function getAllAdmin(Request $request)
    {
        $privacyPolicyData = [];
        $privacyPolicies = Privacypolicy::orderBy('id', 'DESC')->get();
        if ($privacyPolicies) {

            foreach ($privacyPolicies as $pPolicy) {
                $data = [
                    'id' => $pPolicy->id,
                    'privacy_policy' => $pPolicy->privacy_policy ?? NULL,
                    'status' => $pPolicy->status,
                ];

                array_push($privacyPolicyData, $data);
            }

            if (!is_null($privacyPolicyData)) {
                return view('Admin.PrivacyPolicy.privacy-policy-list', compact('privacyPolicyData'));
            } else {
                return view('Admin.PrivacyPolicy.privacy-policy-list');
            }
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'privacy_policy' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {


            $privacyPolicy = new Privacypolicy();
            $privacyPolicy->privacy_policy = $request->privacy_policy;
            $privacyPolicy->status = 1;
            $privacyPolicy->save();

            return response()->json(['status' => true, 'message' => 'Privacy policy Save Successfully.']);
        }
    }

    public function delete(Request $request)
    {

        $privacyPolicy = Privacypolicy::where('id', $request->privacy_policy_id)->first();

        if ($privacyPolicy) {
            $privacyPolicy->delete();
            return response()->json(['status' => true, 'message' => 'Privacy Policy Data Deleted Successfully.']);
        }
    }

    public function changePrivacyPolicyStatus(Request $request)
    {

        $privacyPolicy = Privacypolicy::where('id', $request->privacy_policy_id)->first();

        if ($privacyPolicy) {
            $privacyPolicy->status = !$privacyPolicy->status;
            $privacyPolicy->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }

    public function edit(Request $request, $privacyPolicyId)
    {

        $privacyPolicy = Privacypolicy::where('id', $privacyPolicyId)->first();
        if ($privacyPolicy) {

            $privacyPolicyData = [];

            $privacyPolicyData = [
                'id' => $privacyPolicy?->id,
                'privacy_policy' => $privacyPolicy->privacy_policy ?? NULL,
            ];

            return view('Admin.Priv', compact('privacyPolicyData'));
        }
    }

    public function update(Request $request, $privacyPolicyId)
    {

        $rules = [
            'privacy_policy' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $privacyPolicy = Privacypolicy::where('id', $privacyPolicyId)->first();
            if ($privacyPolicy) {

                if ($request->has('privacy_policy')) {
                    $privacyPolicy->privacy_policy = $request->privacy_policy;
                }

                $privacyPolicy->update();

                return response()->json(['status' => true, 'message' => 'Privacy Policy Updated Successfully']);
            } else {
                return response()->json(['status' => true, 'message' => 'Privacy Policy  Not Found.']);
            }
        }
    }
}
