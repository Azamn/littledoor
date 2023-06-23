<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSubCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterSubCategoryResource;
use App\Models\MasterCategory;

class MasterSubCategoryController extends Controller
{
    public function getAll(Request $request)
    {

        $user = $request->user();
        if ($user) {
            $masterSubCategory = MasterSubCategory::with('masterCategory')->where('status', 1)->get();
            if ($masterSubCategory) {
                return response()->json(['status' => true, 'data' => MasterSubCategoryResource::collection($masterSubCategory)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Master Sub-Categories Not Found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'master_category_id' => 'required|integer|exists:master_categories,id',
            'names.*' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            // $user = $request->user();

            // if ($user) {
            if ($request->has('names')) {
                foreach ($request->names as $name) {
                    $masterSubCategory = new MasterSubCategory();
                    $masterSubCategory->master_category_id = $request->master_category_id;
                    $masterSubCategory->name = $name;
                    $masterSubCategory->status = 1;
                    $masterSubCategory->save();
                }
            }

            return response()->json(['status' => true, 'message' => 'Master Sub-Category Save Successfully.']);
            // }
            // else {
            //     return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            // }
        }
    }

    public function getAllThroughAdmin()
    {

        $masterSubCategoriesData = [];
        $masterSubCategories = MasterSubCategory::with('masterCategory')->get();

        foreach ($masterSubCategories as $masterSubCategory) {
            $data = [
                'id' => $masterSubCategory->id,
                'category_name' => optional(optional($masterSubCategory)->masterCategory)->name ?? NULL,
                'name' => $masterSubCategory->name ?? NULL,
                'status' => $masterSubCategory->status ?? NULL,
            ];

            array_push($masterSubCategoriesData, $data);
        }

        return view('Admin.SubCategory.sub-category-list', compact('masterSubCategoriesData'));
    }

    public function delete(Request $request)
    {

        $masterSubCategories = MasterSubCategory::where('id', $request->sub_category_id)->first();

        if ($masterSubCategories) {
            $masterSubCategories->delete();
            return response()->json(['status' => true, 'message' => 'Sub-Category Data Deleted Successfully.']);
        }
    }

    public function changeSubCategoryStatus(Request $request)
    {

        $masterSubCategories = MasterSubCategory::where('id', $request->sub_category_id)->first();
        if ($masterSubCategories) {
            $masterSubCategories->status = !$masterSubCategories->status;
            $masterSubCategories->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }

    public function getCategoriesData(Request $request)
    {
        $categoriesData = [];
        $categories = MasterCategory::where('status', 1)->get();
        foreach ($categories as $category) {
            $data = [
                'id' => $category->id,
                'name' => $category->name,
            ];

            array_push($categoriesData, $data);
        }

        return view('Admin.SubCategory.sub-category-create', compact('categoriesData'));
    }

    public function edit(Request $request, $subCategoryId)
    {

        $masterSubCategories = MasterSubCategory::with('masterCategory')->where('id', $subCategoryId)->first();
        if ($masterSubCategories) {

            $categoriesData = [];
            $categories = MasterCategory::where('status', 1)->get();
            if ($categories) {
                foreach ($categories as $category) {
                    $data = [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];

                    array_push($categoriesData, $data);
                }
            }

            $masterSubCategoriesData = [];

            $masterSubCategoriesData = [
                'id' => $masterSubCategories->id,
                'category_id' => $masterSubCategories->category_id,
                'category_name' => optional(optional($masterSubCategories)->masterCategory)->name ?? NULL,
                'name' => $masterSubCategories->name ?? NULL,
            ];

            return view('Admin.SubCategory.sub-category-edit', compact('masterSubCategoriesData','categoriesData'));
        }
    }

    public function update(Request $request, $subCategoryId)
    {
        $rules = [
            'master_category_id' => 'sometimes|required|integer|exists:master_categories,id',
            'name' => 'sometimes|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $masterSubCategories = MasterSubCategory::where('id', $subCategoryId)->first();
            if ($masterSubCategories) {
                if ($request->has('name')) {
                    $masterSubCategories->name = $request->name;
                }

                $masterSubCategories->update();

                return response()->json(['status' => true, 'message' => 'Sub-category Updated successfully.']);
            }
        }
    }
}
