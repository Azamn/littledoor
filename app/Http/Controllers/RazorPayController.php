<?php

namespace App\Http\Controllers;

use App\Models\RazorPayTransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RazorPayController extends Controller
{

    public function createPaymentOrder(Request $request)
    {

        $rules = [
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'amount' => 'required|integer',
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
                'amount'  => $request->amount,
                'currency' => 'INR',
            ];

            $paymentTransaction = new RazorPayTransactionLog();
            $paymentTransaction->patient_id = $request->patient_id;
            $paymentTransaction->doctor_id = $request->doctor_id;
            $paymentTransaction->amount = $request->amount;
            $paymentTransaction->request_body = json_encode($requestArray);

            $response = Http::withHeaders($headers)->post($createOrderUrl, $requestArray);

            if ($response->successful()) {
                $responseData =  json_decode($response->body(), true);
                $paymentTransaction->response_body_1 = json_encode($responseData);
                $paymentTransaction->transaction_number = $responseData['id'];
                $paymentTransaction->status = 'Processing';
                $paymentTransaction->save();

                return response()->json(['status' => true, 'data' => $response->json(), 'paymentId' => $paymentTransaction->id]);
            } else {
                return response()->json(['status' => false, 'message' => 'Unable to create Order']);
            }
        }
    }

    public function verifyOrderPayment(Request $request)
    {
        $rules = [
            'payment_id' => 'required|exists:payment_transaction_logs,id',
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
