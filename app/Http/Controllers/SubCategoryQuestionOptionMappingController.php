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

        $SubCategoryQuestionMapping = SubCategoryQuestionMapping::with('subCategory', 'question', 'optionMapping.option')->get();

        if ($SubCategoryQuestionMapping) {
            $finalData = [];
            foreach ($SubCategoryQuestionMapping as $sqpMapping) {

                $optionData = [];
                if ($sqpMapping?->optionMapping) {
                    foreach ($sqpMapping?->optionMapping as $mapping) {
                        $data = [
                            'id' => $mapping->id,
                            'sub_category_question_mapping_id' => $mapping->sub_category_question_mapping_id,
                            'option_id' => $mapping->option_id,
                            'option_name' => $mapping?->option?->name ?? NULL
                        ];
                        array_push($optionData, $data);
                    }
                }

                $mappingData = [
                    'id' => $sqpMapping->id,
                    'sub_category_id' => $sqpMapping->master_sub_category_id,
                    'sub_category_name' => $sqpMapping?->subCategory?->name ?? NULL,
                    'question_id' => $sqpMapping->master_question_id,
                    'question_name' => $sqpMapping?->question?->name ?? NULL,
                    'options' => $optionData ?? NULL
                ];

                array_push($finalData, $mappingData);
            }
            return view('Admin.Mapping.mapping-list', compact('finalData'));
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'sub_category_id' => 'required|integer|exists:master_sub_categories,id',
            'question_id' => 'required|integer|exists:master_questions,id',
            'option_ids.*' => 'required|'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if ($request->has('option_ids')) {

                $optionIds = $request->option_ids;
                $optionIds = array_keys($optionIds);
                DB::transaction(function () use ($request, $optionIds) {
                    $subCategoryQuestionOptionMapping = new SubCategoryQuestionMapping();
                    $subCategoryQuestionOptionMapping->master_sub_category_id = $request->sub_category_id;
                    $subCategoryQuestionOptionMapping->master_question_id = $request->question_id;
                    $subCategoryQuestionOptionMapping->save();

                    $subCategoryQuestionOptionMappingId = $subCategoryQuestionOptionMapping->id;

                    foreach ($optionIds as $optionId) {

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

    public function getSingleMapping(Request $request, $categoryQuestionMappingId)
    {

        $SubCategoryQuestionMapping = SubCategoryQuestionMapping::with('subCategory', 'question', 'optionMapping.option')->where('id', $categoryQuestionMappingId)->first();

        if ($SubCategoryQuestionMapping) {

            $options = [];
            $optionData = [];
            $subCategoryData = [];
            $questionData = [];

            if ($SubCategoryQuestionMapping?->optionMapping) {
                foreach ($SubCategoryQuestionMapping?->optionMapping as $mapping) {
                    $data = [
                        'id' => $mapping->id,
                        'sub_category_question_mapping_id' => $mapping->sub_category_question_mapping_id,
                        'option_id' => $mapping->option_id,
                        'option_name' => $mapping?->option?->name ?? NULL
                    ];
                    array_push($optionData, $data);
                }
            }

            $mappingData = [
                'id' => $SubCategoryQuestionMapping->id,
                'sub_category_id' => $SubCategoryQuestionMapping->master_sub_category_id,
                'sub_category_name' => $SubCategoryQuestionMapping?->subCategory?->name ?? NULL,
                'question_id' => $SubCategoryQuestionMapping?->master_question_id,
                'question_name' => $SubCategoryQuestionMapping?->question?->name ?? NULL,
                'options' => $optionData ?? NULL
            ];

            $masterOptions = MasterOption::where('status', 1)->get();
            if ($masterOptions->isNotEmpty()) {
                foreach ($masterOptions as $key => $option) {
                    $data = [
                        'id' => $option->id,
                        'name' => $option->name,
                    ];

                    array_push($options, $data);
                }
            }

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

            return view('Admin.Mapping.mapping-edit', compact('mappingData', 'options', 'subCategoryData', 'questionData'));
        } else {
            return response()->json(['status' => false, 'message' => 'Mapping Not Found']);
        }
    }

    public function update(Request $request, $categoryQuestionMappingId)
    {

        $rules = [
            'sub_category_id' => 'sometimes|required|integer|exists:master_sub_categories,id',
            'question_id' => 'sometimes|required|integer|exists:master_questions,id',
            'option_ids.*' => 'sometimes|required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $subCategoryQuestionOptionMapping = SubCategoryQuestionMapping::where('id', $categoryQuestionMappingId)->first();

            if ($subCategoryQuestionOptionMapping) {

                if ($request->has('sub_category_id')) {
                    $subCategoryQuestionOptionMapping->master_sub_category_id = $request->sub_category_id;
                }

                if ($request->has('question_id')) {
                    $subCategoryQuestionOptionMapping->master_question_id = $request->question_id;
                }

                $subCategoryQuestionOptionMapping->update();

                if ($request->has('option_ids')) {
                    $optionIds = $request->option_ids;
                    $optionIds = array_keys($optionIds);

                    $subCategoryQuestionMappingWithOption = SubCategoryQuestionMappingWithOption::where('sub_category_question_mapping_id', $subCategoryQuestionOptionMapping->id)->get();
                    if ($subCategoryQuestionMappingWithOption) {
                        foreach ($subCategoryQuestionMappingWithOption as $mapping) {
                            $mapping->delete();
                        }
                    }

                    foreach ($optionIds as $optionId) {

                        $subCategoryQuestionMappingWithOption = new SubCategoryQuestionMappingWithOption();
                        $subCategoryQuestionMappingWithOption->sub_category_question_mapping_id = $subCategoryQuestionOptionMapping->id;
                        $subCategoryQuestionMappingWithOption->option_id = $optionId;
                        $subCategoryQuestionMappingWithOption->save();
                    }
                }

                return response()->json(['status' => true, 'message' => 'Question Mapping Update successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Mapping Not Found']);
            }
        }
    }

    public function delete(Request $request)
    {

        $SubCategoryQuestionMapping = SubCategoryQuestionMapping::where('id', $request->category_question_mapping_id)->first();
        if ($SubCategoryQuestionMapping) {

            $SubCategoryQuestionMappingWithOption = SubCategoryQuestionMappingWithOption::where('sub_category_question_mapping_id', $SubCategoryQuestionMapping)->get();
            if ($SubCategoryQuestionMappingWithOption) {
                foreach ($SubCategoryQuestionMappingWithOption as $mapping) {
                    $mapping->delete();
                }
            }

            $SubCategoryQuestionMapping->delete();

            return response()->json(['status' => true, 'message' => 'Mapping Deleted successfully']);
        } else {

            return response()->json(['status' => false, 'message' => 'Mapping Not Found']);
        }
    }
}
