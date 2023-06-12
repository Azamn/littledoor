<?php

namespace App\Http\Controllers;

use App\Models\MasterOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasteOptionResource;

class MasterOptionsController extends Controller
{
    public function getAll(Request $request){

        $user = $request->user();
        if($user){
            $masterOptions = MasterOption::where('status',1)->get();
            if($masterOptions){
                return response()->json(['status' => true, 'data' => MasteOptionResource::collection($masterOptions)]);
            }else{
                return response()->json(['status' => false, 'message' => 'Options Not Found.']);
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

                $masterOption = new MasterOption();
                $masterOption->name = $request->name;
                $masterOption->status = 1;
                $masterOption->save();

                return response()->json(['status' => true, 'message' => 'Option Save Successfully.']);
            }else{
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }

    public function createThroughAdmin(Request $request)
    {

        $rules = [
            'options.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if ($request->has('options')) {
                foreach ($request->options as $key => $option) {
                    $masterOptions = new MasterOption();
                    $masterOptions->name = $option;
                    $masterOptions->status = 1;
                    $masterOptions->save();
                }

                return response()->json(['status' => true, 'message' => 'Options Added Successfully.']);
            }
        }
    }

    public function getAllThroughAdmin(Request $request)
    {

        $masterOptionsData = [];
        $masterOptions = MasterOption::get();

        foreach ($masterOptions as $options) {
            $data = [
                'id' => $options?->id,
                'name' => $options?->name,
                'status' => $options?->status,
            ];

            array_push($masterOptionsData, $data);
        }

        return view('Admin.Options.options-list', compact('masterOptionsData'));
    }

    public function delete(Request $request)
    {

        $masterOptions = MasterOption::where('id', $request->option_id)->first();

        if ($masterOptions) {
            $masterOptions->delete();
            return response()->json(['status' => true, 'message' => 'Option Deleted Successfully.']);
        }
    }

    public function changeOptionStatus(Request $request)
    {

        $masterOptions = MasterOption::where('id', $request->option_id)->first();
        if ($masterOptions) {
            $masterOptions->status = !$masterOptions->status;
            $masterOptions->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }
}
