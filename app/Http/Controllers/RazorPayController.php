<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use App\Models\MasterDay;
use App\Models\MasterDoctor;
use Illuminate\Http\Request;
use App\Models\MasterPatient;
use App\Services\FCM\FCMService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\RazorPayTransactionLog;
use Illuminate\Support\Facades\Validator;

class RazorPayController extends Controller
{

    public function createPaymentOrder(Request $request)
    {

        $rules = [
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'amount' => 'required|integer',
            'tax_amount' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $keysString = env('RAZORPAY_KEY') . ':' . env('RAZORPAY_SECERT');

            $headers = [
                'Authorization' => 'Basic ' . base64_encode($keysString),
                'content-type' => 'application/json',
            ];

            $createOrderUrl = 'https://api.razorpay.com/v1/orders';

            $requestArray = [
                'receipt' => 'order' . random_int(1, 1000),
                'amount'  => $request->amount * 100,
                'currency' => 'INR',
            ];

            $paymentTransaction = new RazorPayTransactionLog();
            $paymentTransaction->patient_id = $request->patient_id;
            $paymentTransaction->doctor_id = $request->doctor_id;
            $paymentTransaction->amount = $request->amount;
            $paymentTransaction->tax_amount = $request->tax_amount;
            $paymentTransaction->request_body = json_encode($requestArray);
            $paymentTransaction->transaction_number = "updated after successful response";
            $paymentTransaction->save();

            $paymentTransactionId = $paymentTransaction->id;

            $response = Http::withHeaders($headers)->post($createOrderUrl, $requestArray);

            if ($response) {
                $paymentTransaction = RazorPayTransactionLog::where('id', $paymentTransactionId)->first();
                $responseData =  json_decode($response->body(), true);
                $paymentTransaction->response_body_1 = json_encode($responseData);
                $paymentTransaction->update();

                if ($response->successful()) {
                    $responseData =  json_decode($response->body(), true);
                    $paymentTransaction->response_body_1 = json_encode($responseData);
                    $paymentTransaction->transaction_number = $responseData['id'];
                    $paymentTransaction->status = 'Processing';
                    $paymentTransaction->save();

                    return response()->json(['status' => true, 'data' => $response->json(), 'paymentId' => $paymentTransaction->id]);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Unable to create Order']);
            }
        }
    }

    public function verifyOrderPayment(Request $request)
    {
        $rules = [
            'payment_id' => 'required|exists:razor_pay_transaction_logs,id',
            'order_id' => 'required',
            'razorpay_payment_id' => 'sometimes|required',
            'razorpay_order_id' => 'sometimes|required',
            'razorpay_signature' => 'sometimes|required',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $paymentDataLog = RazorPayTransactionLog::where('id', $request->payment_id)->where('transaction_number', $request->order_id)->first();

            if ($request->has('razorpay_signature')) {
                if ($paymentDataLog) {

                    $paymentDataLog->transaction_ref_no = $request->razorpay_payment_id;
                    $paymentDataLog->response_body_2 = json_encode($request->all());
                    $paymentDataLog->save();

                    $orderId = $paymentDataLog->transaction_number;

                    $stringToEncrypt = $orderId . "|" . $request->razorpay_payment_id;

                    $secert = env('RAZORPAY_SECERT');

                    $generatedSignature = hash_hmac('sha256', $stringToEncrypt, $secert);

                    if ($generatedSignature == $request->razorpay_signature) {
                        $paymentDataLog->status = 'Success';
                        $paymentDataLog->save();

                        /** For Patient Notification*/
                        $eventNmae = 'Transaction';

                        $doctor = MasterDoctor::where('id', $paymentDataLog->doctor_id)->first();
                        $patient = MasterPatient::where('id', $paymentDataLog->patient_id)->first();

                        $title = "Payment Transfer";
                        $channelName = "payment_notification";
                        $patientBody = 'Dear ' . $patient?->first_name . ', Your payment of amount ' . $paymentDataLog->amount . ' has been successfully transfered to  ' . $doctor?->first_name . ' at ' . now();

                        $patientUserId = $patient->user_id;
                        $tokenData = FcmToken::where('user_id', $patientUserId)->select('fcm_token', 'user_id', 'platform_id')->get();
                        if ($tokenData) {
                            $fcmService = new FCMService();
                            $fcmService->sendNotifications($tokenData, $title, $patientBody, $eventNmae, $channelName);
                        }


                        /** End Patient Notification*/

                        /** For Doctor Notification */
                        $title = "Payment Received";
                        $channelName = "payment_notification";
                        $doctorBody = 'Dear ' . $doctor?->first_name . ' you have received your payment of amount ' . $paymentDataLog->amount . ' from ' . $patient?->first_name . ' at ' . now();

                        $doctorUserId = $doctor->user_id;
                        $tokenData = FcmToken::where('user_id', $doctorUserId)->select('fcm_token', 'user_id', 'platform_id')->get();
                        if ($tokenData) {
                            $fcmService = new FCMService();
                            $fcmService->sendNotifications($tokenData, $title, $doctorBody, $eventNmae, $channelName);
                        }


                        /** End For Doctor Notification */


                        return response()->json(['status' => true, 'message' => 'Payment Successful']);
                    } else {
                        $paymentDataLog->status = 'Failure';
                        $paymentDataLog->save();

                        return response()->json(['status' => false, 'message' => 'Payment Failed']);
                    }
                }
            }
        }
    }
}
