<?php

namespace App\Http\Controllers;

use App\Models\MasterCity;
use Illuminate\Http\Request;
use App\Http\Resources\MasterCityResource;

class MasterCityController extends Controller
{

    public function getCity(Request $request)
    {

        $cities = MasterCity::with('state')->where('status', 1)->distinct()->get();

        if ($cities) {
            return response()->json(['status' => true, 'data' => MasterCityResource::collection($cities)]);
        } else {
            return response()->json(['status' => false, 'message' => 'Cities Not Found.']);
        }
    }
}
