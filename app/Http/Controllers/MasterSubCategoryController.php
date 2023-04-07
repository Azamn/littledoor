<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSubCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterSubCategoryResource;

class MasterSubCategoryController extends Controller
{
    public function getAll(Request $request){

        $user = $request->user();
        if($user){
            $masterSubCategory = MasterSubCategory::with('masterCategory')->where('status',1)->get();
            if($masterSubCategory){
                return response()->json(['status' => true, 'data' => MasterSubCategoryResource::collection($masterSubCategory)]);
            }else{
                return response()->json(['status' => false, 'message' => 'Master Sub-Categories Not Found.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }

    }

    public function create(Request $request){

        $rules = [
            'name' => 'required',
            'master_category_id' => 'required|integer|exists:master_categories,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $user = $request->user();

            if ($user) {

                $masterSubCategory = new MasterSubCategory();
                $masterSubCategory->master_category_id = $request->master_category_id;
                $masterSubCategory->name = $request->name;
                $masterSubCategory->status = 1;
                $masterSubCategory->save();

                return response()->json(['status' => true, 'message' => 'Master Sub-Category Save Successfully.']);
            }else{
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }
}
