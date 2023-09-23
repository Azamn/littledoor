<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\PromotionResource;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{

    public function getPromotions(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $todayDate = Carbon::parse(now())->toDateString();

            $masterPromotions = Promotion::with('media')->orWhere('is_always', 1)->orWhere('end_date', '>=', $todayDate)->where('status', 1)->get();

            if ($masterPromotions) {

                return response()->json(['status' => true, 'data' => PromotionResource::collection($masterPromotions)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Not Found']);
            }
        }
    }


    public function createPromotion(Request $request)
    {

        $rules = [
            'title' => 'required|string',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'is_always' => 'sometimes|required',
            'image' => 'required|file|mimes:jpg,png,jpeg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $promotion = new Promotion();
            $promotion->title = $request->title;

            if ($request->has('start_date') && !is_null($request->start_date)) {
                $promotion->start_date = Carbon::parse($request->start_date)->toDateString();
            }

            if ($request->has('end_date') && !is_null($request->end_date)) {
                $promotion->end_date = Carbon::parse($request->end_date)->toDateString();
            }

            if ($request->has('is_always')) {
                $promotion->is_always = 1;
            }

            if ($request->has('image')) {
                $promotion->addMediaFromRequest('image')->toMediaCollection('promotion-images');
            }
            $promotion->status = 1;
            $promotion->save();

            return response()->json(['status' => true, 'message' => 'Promotion Added Successfully.']);
        }
    }

    public function getAllPromotionsThroughAdmin(Request $request)
    {

        $user = $request->user();
        if ($user) {

            $masterPromotionsData = [];

            $masterPromotions = Promotion::with('media')->get();

            if ($masterPromotions) {

                foreach ($masterPromotions as $promotion) {
                    $startDate = NULL;
                    $endDate = NULL;

                    if (!is_null($promotion->start_date)) {
                        $startDate = Carbon::parse($promotion->start_date)->format('d-m-Y');
                    }

                    if (!is_null($promotion->end_date)) {
                        $endDate = Carbon::parse($promotion->end_date)->format('d-m-Y');
                    }

                    if ($promotion->is_always == 1) {
                        $isAlways = 'Yes';
                    } else {
                        $isAlways = 'No';
                    }

                    $data = [
                        'id' => $promotion->id,
                        'title' => $promotion->title ?? NULL,
                        'image_url' => $promotion->media->isNotEmpty() ? $promotion->media->last()->getFullUrl() : NULL,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'is_always' => $isAlways,
                        'status' => $promotion->status ?? NULL,
                    ];

                    array_push($masterPromotionsData, $data);
                }

                if (!is_null($masterPromotionsData)) {
                    return view('Admin.Promotion.promotion-list', compact('masterPromotionsData'));
                }
            }
        }
    }

    public function deletePromotion(Request $request)
    {
        $masterPromotion = Promotion::where('id', $request->promotion_id)->first();

        if ($masterPromotion) {
            $masterPromotion->delete();
            return response()->json(['status' => true, 'message' => 'Promotion Data Deleted Successfully.']);
        }
    }

    public function changePromotionStatus(Request $request)
    {
        $masterPromotion = Promotion::where('id', $request->promotion_id)->first();
        if ($masterPromotion) {
            $masterPromotion->status = !$masterPromotion->status;
            $masterPromotion->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }
}
