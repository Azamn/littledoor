<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PortalSericeCharges;
use Illuminate\Support\Facades\Validator;

class PortalServiceController extends Controller
{

    public function getAllAdmin(Request $request)
    {
        $portalServiceChargeData = [];
        $portalServiceCharges = PortalSericeCharges::orderBy('id', 'DESC')->get();
        if ($portalServiceCharges) {

            foreach ($portalServiceCharges as $portalService) {
                $data = [
                    'id' => $portalService->id,
                    'tax' => $portalService->tax ?? NULL,
                    'platform_fee' => $portalService->platform_fee ?? NULL,
                ];

                array_push($portalServiceChargeData, $data);
            }

            if (!is_null($portalServiceChargeData)) {
                return view('Admin.PortalService.portal-service-list', compact('portalServiceChargeData'));
            } else {
                return view('Admin.PortalService.portal-service-list');
            }
        }
    }
    
    public function createPortalService(Request $request)
    {

        $rules = [
            'tax' => 'sometimes|required',
            'platform_fee' => 'sometimes|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $portalServiceCharges = PortalSericeCharges::get();
            if($portalServiceCharges){
                $portalServiceCharges->each->delete();
            }

            $portalService = new PortalSericeCharges();
            $portalService->tax = $request->tax;
            $portalService->platform_fee = $request->platform_fee;
            $portalService->save();

            return response()->json(['status' => true, 'message' => 'Portal service charges added.']);
        }
    }

    public function edit(Request $request, $portalServiceChargeId)
    {

        $portalServiceCharges = PortalSericeCharges::where('id', $portalServiceChargeId)->first();
        if ($portalServiceCharges) {

            $portalServiceChargeData = [];

            $portalServiceChargeData = [
                'id' => $portalServiceCharges?->id,
                'tax' => $portalServiceCharges?->tax ?? NULL,
                'platform_fee' => $portalServiceCharges?->platform_fee ?? NULL,
            ];

            return view('Admin.PortalService.portal-service-edit', compact('portalServiceChargeData'));
        }
    }

    public function update(Request $request, $portalServiceChargeId)
    {

        $rules = [
            'tax' => 'sometimes|required',
            'platform_fee' => 'sometimes|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $portalServiceCharges = PortalSericeCharges::where('id', $portalServiceChargeId)->first();
            if ($portalServiceCharges) {

                if ($request->has('tax')) {
                    $portalServiceCharges->tax = $request->tax;
                }

                if ($request->has('platform_fee')) {
                    $portalServiceCharges->platform_fee = $request->platform_fee;
                }

                $portalServiceCharges->update();

                return response()->json(['status' => true, 'message' => 'Portal Service Charges Updated Successfully']);
            } else {
                return response()->json(['status' => true, 'message' => 'Portal Service Charges  Not Found.']);
            }
        }
    }

    public function delete(Request $request)
    {

        $portalServiceCharges = PortalSericeCharges::where('id', $request->portal_service_charges_id)->first();

        if ($portalServiceCharges) {
            $portalServiceCharges->delete();
            return response()->json(['status' => true, 'message' => 'Portal Service Charges Data Deleted Successfully.']);
        }
    }

}
