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

            $portalService = new PortalSericeCharges();
            $portalService->tax = $request->tax;
            $portalService->platform_fee = $request->platform_fee;
            $portalService->save();

            return response()->json(['status' => true, 'message' => 'Portal service charges added.']);
        }
    }

}
