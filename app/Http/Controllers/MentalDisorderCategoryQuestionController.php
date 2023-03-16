<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MentalDisorderCategoryQuestionMapping;
use App\Http\Resources\MentalDisorderCategoryQuestionResource;

class MentalDisorderCategoryQuestionController extends Controller
{

    public function create(Request $request)
    {

        $rules = [
            'mental_disorder_category_id' => 'required|exists:mental_disorder_categories,id',
            'question' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $mentalDisorderQuestion = new MentalDisorderCategoryQuestionMapping();
                $mentalDisorderQuestion->mental_disorder_category_id = $request->mental_disorder_category_id;
                $mentalDisorderQuestion->question = $request->question;
                $mentalDisorderQuestion->status = 1;
                $mentalDisorderQuestion->save();

                return response()->json(['status' => true, 'message' => 'Mental Disorder Catgeory Question Mapping Create Susscessfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }

    public function getAll(Request $request)
    {
        $user = $request->user();

        if ($user) {

            $mentalDisorderQuestionData = MentalDisorderCategoryQuestionMapping::with(['mentalDisorderCategory' => function ($mentalDisorderCategory) {
                return $mentalDisorderCategory->whereNull('deleted_at');
            }])->where('status', 1)->get();

            if ($mentalDisorderQuestionData) {
                return response()->json(['status' => true, 'data' => MentalDisorderCategoryQuestionResource::collection($mentalDisorderQuestionData)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Mental Disorder Question Nor Found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

    public function delete(Request $request, $mentalDisorderQuestionId)
    {
        $user = $request->user();

        if ($user) {
            $mentalDisorderQuestion = MentalDisorderCategoryQuestionMapping::where('id', $mentalDisorderQuestionId)->first();
            if ($mentalDisorderQuestion) {
                $mentalDisorderQuestion->delete();
                return response()->json(['status' => true, 'message' => 'Mental Disorder Question Mapping Deleted Successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Mental Disorder Question Mapping Not Found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }
}
