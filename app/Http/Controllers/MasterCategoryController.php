<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterCategoryResource;

class MasterCategoryController extends Controller
{
    public function getAll(Request $request)
    {

        $user = $request->user();
        if ($user) {
            $masterCategory = MasterCategory::where('status', 1)->get();
            if ($masterCategory) {
                return response()->json(['status' => true, 'data' => MasterCategoryResource::collection($masterCategory)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Master Categories Not Found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $user = $request->user();

            if ($user) {

                $masterCategory = new MasterCategory();
                $masterCategory->name = $request->name;
                $masterCategory->status = 1;
                $masterCategory->save();

                return response()->json(['status' => true, 'message' => 'Master Category Save Successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }

    public function getAllThroughAdmin(Request $request)
    {

        $masterCategoriesData = [];
        $masterCategoriess = MasterCategory::with('media')->get();

        foreach ($masterCategoriess as $masterCategories) {
            $data = [
                'id' => $masterCategories->id,
                'name' => $masterCategories->name ?? NULL,
                'image_url' => $masterCategories->media->isNotEmpty() ? $masterCategories->media->last()->getFullUrl() : NULL,
                'status' => $masterCategories->status ?? NULL,
            ];

            array_push($masterCategoriesData, $data);
        }

        if (!is_null($masterCategoriesData)) {
            return view('Admin.Category.category-list', compact('masterCategoriesData'));
        } else {
            return view('Admin.Category.category-list');
        }
    }

    public function createThroughAdmin(Request $request)
    {
        $rules = [
            'name' => 'required|string|regex:/^[a-zA-Z- ]*$/|max:100',
            'image' => 'required|file|mimes:jpg,png,jpeg'
        ];

        $messages = [
            'name.required' => 'Name Field is required',
            'name.regex' => 'Name Should Contain Only Letters.',
            'image.required' => 'Image Should be required.',
            'image.mimes' => 'The :attribute should be valid file',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $masterCategories = new MasterCategory();
            $masterCategories->name = $request->name;
            $masterCategories->status = 1;

            if ($request->has('image')) {
                $masterCategories->addMediaFromRequest('image')->toMediaCollection('master-category');
            }

            $masterCategories->save();

            return response()->json(['status' => true, 'message' => 'Category Details Added Successfully.']);
        }
    }

    public function delete(Request $request)
    {

        $masterCategories = MasterCategory::where('id', $request->category_id)->first();

        if ($masterCategories) {
            $masterCategories->delete();
            return response()->json(['status' => true, 'message' => 'Category Data Deleted Successfully.']);
        }
    }

    public function changeCategoryStatus(Request $request)
    {

        $masterCategories = MasterCategory::where('id', $request->category_id)->first();
        if ($masterCategories) {
            $masterCategories->status = !$masterCategories->status;
            $masterCategories->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }

    public function edit(Request $request, $categoryId)
    {

        $masterCategory = MasterCategory::with('media')->where('id', $categoryId)->first();
        if ($masterCategory) {

            $categoryData = [];

            $categoryData = [
                'id' => $masterCategory?->id,
                'name' => $masterCategory?->name,
                'image_url' => $masterCategory->media->isNotEmpty() ? $masterCategory->media->last()->getFullUrl() : NULL,
            ];

            return view('Admin.Category.category-edit', compact('categoryData'));
        }
    }

    public function update(Request $request, $categoryId)
    {

        $rules = [
            'name' => 'sometimes|required|string|max:100',
            'image' => 'sometimes|nullable|file|mimes:jpg,png,jpeg',
        ];

        $messages = [
            'name.required' => 'Name Field is required',
            'image.required' => 'Image Should be required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $masterCategory = MasterCategory::with('media')->where('id', $categoryId)->first();
            if ($masterCategory) {

                if ($request->has('name')) {
                    $masterCategory->name = $request->name;
                }

                if ($request->has('image')) {
                    $masterCategory->addMediaFromRequest('image')->toMediaCollection('master-category');
                }

                $masterCategory->update();

                return response()->json(['status' => true, 'message' => 'Category Updated Successfully']);
            } else {
                return response()->json(['status' => true, 'message' => 'Category Not Found.']);
            }
        }
    }
}
