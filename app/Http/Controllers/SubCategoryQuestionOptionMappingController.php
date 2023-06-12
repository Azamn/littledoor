<?php

namespace App\Http\Controllers;

use App\Models\MasterOption;
use App\Models\MasterQuestion;
use App\Models\MasterSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategoryQuestionMapping;
use App\Models\SubCategoryQuestionMappingWithOption;

class SubCategoryQuestionOptionMappingController extends Controller
{

    public function getAll(Request $request)
    {
    }

    public function create(Request $request)
    {

        $rules = [
            'sub_category_id' => 'required|integer|exists:master_sub_categories,id',
            'questio_id' => 'required|integer|exists:master_questions,id',
            'option_ids.*' => 'required|integer'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if ($request->has('option_ids')) {
                DB::transaction(function () use ($request) {
                    $subCategoryQuestionOptionMapping = new SubCategoryQuestionMapping();
                    $subCategoryQuestionOptionMapping->master_sub_category_id = $request->sub_category_id;
                    $subCategoryQuestionOptionMapping->master_question_id = $request->questio_id;
                    $subCategoryQuestionOptionMapping->save();

                    $subCategoryQuestionOptionMappingId = $subCategoryQuestionOptionMapping->id;

                    foreach ($request->option_ids as $optionId) {
                        $subCategoryQuestionMappingWithOption = new SubCategoryQuestionMappingWithOption();
                        $subCategoryQuestionMappingWithOption->sub_category_question_mapping_id = $subCategoryQuestionOptionMappingId;
                        $subCategoryQuestionMappingWithOption->option_id = $optionId;
                        $subCategoryQuestionMappingWithOption->save();
                    }
                });
                return response()->json(['status' => true, 'message' => 'Category Question Option Mapping Save Successfully.']);
            }
        }
    }

    public function getSubCategoryQuestionAndOptionForCreate(Request $request)
    {

        $subCategoryData = [];
        $questionData = [];
        $optionsData = [];

        $subCategory = MasterSubCategory::where('status', 1)->get();
        if ($subCategory->isNotEmpty()) {
            foreach ($subCategory as $key => $category) {
                $data = [
                    'id' => $category?->id,
                    'name' => $category?->name,
                ];

                array_push($subCategoryData, $data);
            }
        }

        $questionIds = SubCategoryQuestionMapping::pluck('master_question_id')->toArray();
        if (!is_null($questionIds)) {
            $masterQuestions = MasterQuestion::whereNotIn('id', $questionIds)->where('status', 1)->get();
            if ($masterQuestions->isNotEmpty()) {
                foreach ($masterQuestions as $key => $question) {
                    $data = [
                        'id' => $question?->id,
                        'name' => $question?->name,
                    ];

                    array_push($questionData, $data);
                }
            }
        } else {
            $masterQuestions = MasterQuestion::where('status', 1)->get();
            if ($masterQuestions->isNotEmpty()) {
                foreach ($masterQuestions as $key => $question) {
                    $data = [
                        'id' => $question?->id,
                        'name' => $question?->name,
                    ];

                    array_push($questionData, $data);
                }
            }
        }

        $options = MasterOption::where('status', 1)->get();
        if ($options->isNotEmpty()) {
            foreach ($options as $key => $option) {
                $data = [
                    'id' => $option->id,
                    'name' => $option->name,
                ];

                array_push($optionsData, $data);
            }
        }

        return view('Admin.Mapping.mapping-create', compact('subCategoryData', 'questionData', 'optionsData'));
    }
}
