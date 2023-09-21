<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{

    public function createPromotion(Request $request)
    {

        $rules = [
            'title' => 'required|string',
            'start_date' => 'sometimes|required',
            'end_date' => 'sometimes|required',
            'is_always' => 'sometimes|required',
            'images.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $promotion = new Promotion();
            $promotion->title = $request->title;

            if ($request->has('start_date')) {
                $promotion->start_date = $request->start_date;
            }

            if ($request->has('end_date')) {
                $promotion->end_date = $request->end_date;
            }

            if ($request->has('is_always')) {
                $promotion->is_always = $request->is_always;
            }

            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $promotion->addMedia($image)->toMediaCollection('promotion-images');
                }
            }

            return response()->json(['status' => true, 'Promotion Added Successfully.']);
        }
    }
}
