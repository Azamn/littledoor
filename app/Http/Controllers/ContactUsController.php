<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{

    public function createContactUs(Request $request){

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'message' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }else{

            $contactUs = new ContactUs();
            $contactUs->name = $request->name;
            $contactUs->email = $request->email;
            $contactUs->message = $request->message;
            $contactUs->save();

            return response()->json(['status' => true, 'message' => 'Your Request Send Successfully.']);

        }

    }

}
