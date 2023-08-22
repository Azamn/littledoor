<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterEmotions;
use App\Http\Resources\MasterEmotionsResource;

class DailyJournalController extends Controller
{

    public function getAllEmotions(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $masterEmptions = MasterEmotions::where('status', 1)->get();
            if ($masterEmptions) {
                return response()->json(['status' => true, 'data' => MasterEmotionsResource::collection($masterEmptions)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Not Found']);
            }
        }
    }
}
