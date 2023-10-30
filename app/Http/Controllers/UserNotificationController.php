<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserNotificationResource;

class UserNotificationController extends Controller
{

    public function getUserNotification(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $userNotification = UserNotification::where('user_id', $user->id)->where('is_read', 0)->get();
            if ($userNotification) {
                return response()->json(['status' => true, 'data' => UserNotificationResource::collection($userNotification)]);
            }
        }
    }

    public function updateIsRead(Request $request)
    {

        $rules = [
            'notification_id' => 'required|integer',
            'is_read' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $userNotification = UserNotification::where('id', $request->notification_id)->first();
                if ($userNotification) {
                    $userNotification->is_read = $request->is_read;
                    $userNotification->save();

                    return response()->json(['status' => true, 'message' => 'Update Successfully']);
                }
            }
        }
    }
}
