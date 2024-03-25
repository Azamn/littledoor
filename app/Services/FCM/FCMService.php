<?php

namespace App\Services\FCM;

use Exception;
use Carbon\Carbon;
use App\Models\FcmToken;
use App\Models\PushNotificationLog;
use Illuminate\Support\Facades\Http;

class FCMService
{
    public $serverKey;
    public $fcmEndpoint;

    public function __construct()
    {
        // Initialize FCM settings
        $this->serverKey = env('FCM_SERVER_KEY');
        $this->fcmEndpoint = 'https://fcm.googleapis.com/fcm/send';
    }

    public function sendNotifications($tokensData, $title, $body, $eventName)
    {
        $headers = [
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ];


        foreach ($tokensData as $tokenData) {

            $platformId = $tokenData->platform_id;

            if ($platformId == FcmToken::WEB) {

                $notificationData = [
                    'to' => $tokenData->fcm_token,
                    'data' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ];
            } else {

                $notificationData = [
                    'to' => $tokenData->fcm_token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ];
            }

            $userId = $tokenData->user_id;

            $logData = [
                'event_name' => $eventName,
                'platform_id' => $tokenData?->platform_id,
            ];

            if ($tokensData->count() == 1) {
                return $this->sendRequest($headers, $notificationData, $userId, $logData);
            } else {
                $this->sendRequest($headers, $notificationData, $userId, $logData);
            }
        }
    }

    protected function sendRequest($headers, $data, $userId, $logData)
    {
        try {
            $response = Http::withHeaders($headers)->post($this->fcmEndpoint, $data);

            $responseData = $response->json();

            if ($response->successful()) {

                $success = $responseData['success'];

                if ($success == 1) {
                    PushNotificationLog::create([
                        'user_id' => $userId,
                        'platform_id' => @$logData['platform_id'],
                        'event_name' => @$logData['event_name'],
                        'request' => json_encode($data),
                        'response' => json_encode($responseData),
                        'status' => true,
                    ]);

                    return true;
                } else {

                    $errorMessage = $responseData['results'][0]['error'] ?? NULL;

                    PushNotificationLog::create([
                        'user_id' => $userId,
                        'platform_id' => @$logData['platform_id'],
                        'event_name' => @$logData['event_name'],
                        'request' => json_encode($data),
                        'response' => json_encode($responseData),
                        'error_message' => $errorMessage,
                        'status' => false,
                    ]);

                    return false;
                }
            } else {

                PushNotificationLog::create([
                    'user_id' => $userId,
                    'platform_id' => @$logData['platform_id'],
                    'event_name' => @$logData['event_name'],
                    'request' => json_encode($data),
                    'response' => json_encode($responseData),
                    'status' => false,
                ]);

                return false;
            }
        } catch (\Exception $e) {
            PushNotificationLog::create([
                'user_id' => $userId,
                'platform_id' => @$logData['platform_id'],
                'event_name' => @$logData['event_name'],
                'request' => json_encode($data),
                'status' => false,
                'error_message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
