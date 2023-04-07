<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategoryQuestionOptionMapping;

class SubCategoryQuestionOptionMappingController extends Controller
{
    public function create(Request $request)
    {

        $rules = [
            'sub_category_id' => 'required|integer|exists:master_sub_categories,id',
            'questio_id' => 'required|integer|exists:master_questions,id',
            'option_ids.*' => 'required|integer|array'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {
                if ($request->has('option_ids')) {
                    foreach ($request->option_ids as $optionId) {
                        $SubCategoryQuestionOptionMapping = new SubCategoryQuestionOptionMapping();
                        $SubCategoryQuestionOptionMapping->master_sub_category_id = $request->sub_category_id;
                        $SubCategoryQuestionOptionMapping->master_question_id = $request->questio_id;
                        $SubCategoryQuestionOptionMapping->master_option_id = $optionId;
                        $SubCategoryQuestionOptionMapping->save();
                    }
                    return response()->json(['status' => true, 'message' => 'Category Question Option Mapping Save Successfully.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }
}
