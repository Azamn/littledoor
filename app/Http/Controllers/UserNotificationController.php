<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
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
}
