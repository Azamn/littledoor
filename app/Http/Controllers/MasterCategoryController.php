<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterCategoryResource;

class MasterCategoryController extends Controller
{
    public function getAll(Request $request){

        $user = $request->user();
        if($user){
            $masterCategory = MasterCategory::where('status',1)->get();
            if($masterCategory){
                return response()->json(['status' => true, 'data' => MasterCategoryResource::collection($masterCategory)]);
            }else{
                return response()->json(['status' => false, 'message' => 'Master Categories Not Found.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }

    }

    public function create(Request $request){

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
            }else{
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }
}
