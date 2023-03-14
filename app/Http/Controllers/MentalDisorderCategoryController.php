<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentalDisorderCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MentalDisorderCategoriesResource;

class MentalDisorderCategoryController extends Controller
{

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

                $mentalDisorderCategory = new MentalDisorderCategory();
                $mentalDisorderCategory->name = $request->name;
                $mentalDisorderCategory->status = 1;
                $mentalDisorderCategory->save();

                return response()->json(['status' => true, 'message' => 'Mental Disorder Category Save Successfully.']);
            }else{
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }

    public function getAll(Request $request){

        $user = $request->user();
        if($user){
            $mentalDisorderCategories = MentalDisorderCategory::where('status',1)->get();
            if($mentalDisorderCategories){
                return response()->json(['status' => true, 'data' => MentalDisorderCategoriesResource::collection($mentalDisorderCategories)]);
            }else{
                return response()->json(['status' => false, 'message' => 'Mental Disorder Categories Not Found.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }

    }

    public function delete(Request $request, $mentalDisorderCategoriId){

        $user = $request->user();
        if($user){
            $mentalDisorderCategory = MentalDisorderCategory::where('id',$mentalDisorderCategoriId)->first();
            if($mentalDisorderCategory){
                $mentalDisorderCategory->delete();
                return response()->json(['status' => true, 'message' => 'Mental Disorder Category Deleted Successfully.']);
            }else{
                return response()->json(['status' => false, 'message' => 'Mental Disorder Category Not Found.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }

    }
}
