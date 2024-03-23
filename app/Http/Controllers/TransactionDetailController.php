<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DoctorPaymentRequest;
use App\Models\RazorPayTransactionLog;
use Illuminate\Support\Facades\Validator;

class TransactionDetailController extends Controller
{
    public function getAllTransaction(Request $request)
    {

        $transcationData = RazorPayTransactionLog::with('patient', 'doctor')->orderBy('id', 'desc')->get();
        if ($transcationData) {
            $transactionDetails = [];
            foreach ($transcationData as $transaction) {

                $patientFullName = NULL;
                $doctorFullName = NULL;

                if ($transaction->patient) {
                    if (!is_null($transaction->patient?->first_name) && !is_null($transaction->patient?->last_name)) {
                        $patientFullName = $transaction->patient?->first_name . ' ' . $transaction->patient?->last_name;
                    } else {
                        $patientFullName =  $transaction->patient?->first_name;
                    }
                }

                if ($transaction->doctor) {
                    if (!is_null($transaction->doctor?->first_name) && !is_null($transaction->doctor?->last_name)) {
                        $doctorFullName = $transaction->doctor?->first_name . ' ' . $transaction->doctor?->last_name;
                    } else {
                        $doctorFullName =  $transaction->doctor?->first_name;
                    }
                }

                $data = [
                    'id' => $transaction->id,
                    'patient_name' => $patientFullName ?? NULL,
                    'doctor_name' => $doctorFullName ?? NULL,
                    'amount' => $transaction->amount,
                    'transaction_number' => $transaction->transaction_number,
                    'status' => $transaction->status,
                    'created_at' => Carbon::parse($transaction->created_at)->format('d-m-Y H:i:s'),
                ];

                array_push($transactionDetails, $data);
            }

            if (!is_null($transactionDetails)) {
                return view('Admin.Transactions.all-transactions', compact('transactionDetails'));
            } else {
                return view('Admin.Transactions.all-transactions');
            }
        }
    }

    public function doctorRequestPayment(Request $request)
    {

        $doctorPaymentRequest = DoctorPaymentRequest::with('doctor')->where('status', 0)->orderBy('id', 'desc')->get();
        if ($doctorPaymentRequest) {

            $doctorPaymentRequestData = [];

            foreach ($doctorPaymentRequest as $requestPayment) {

                if ($requestPayment->doctor) {
                    if (!is_null($requestPayment->doctor?->first_name) && !is_null($requestPayment->doctor?->last_name)) {
                        $doctorFullName = $requestPayment->doctor?->first_name . ' ' . $requestPayment->doctor?->last_name;
                    } else {
                        $doctorFullName =  $requestPayment->doctor?->first_name;
                    }
                }

                $data = [
                    'id' => $requestPayment->id,
                    'doctor_name' => $doctorFullName ?? NULL,
                    'request_amount' => $requestPayment->request_amount,
                    'created_at' => Carbon::parse($requestPayment->created_at)->format('d-m-Y H:i:s'),
                ];

                array_push($doctorPaymentRequestData, $data);
            }

            if (!is_null($doctorPaymentRequestData)) {
                return view('Admin.Transactions.doctor-payment-request', compact('doctorPaymentRequestData'));
            } else {
                return view('Admin.Transactions.doctor-payment-request');
            }
        }
    }

    public function requestPaymentDone(Request $request)
    {
        $doctorPaymentRequest = DoctorPaymentRequest::with('doctor')->where('status', 1)->orderBy('id', 'desc')->get();
        if ($doctorPaymentRequest) {

            $doctorPaymentRequestData = [];

            foreach ($doctorPaymentRequest as $requestPayment) {

                if ($requestPayment->doctor) {
                    if (!is_null($requestPayment->doctor?->first_name) && !is_null($requestPayment->doctor?->last_name)) {
                        $doctorFullName = $requestPayment->doctor?->first_name . ' ' . $requestPayment->doctor?->last_name;
                    } else {
                        $doctorFullName =  $requestPayment->doctor?->first_name;
                    }
                }

                $data = [
                    'id' => $requestPayment->id,
                    'doctor_name' => $doctorFullName ?? NULL,
                    'request_amount' => $requestPayment->request_amount,
                    'transaction_number' => $requestPayment->transaction_number,
                    'updated_at' => Carbon::parse($requestPayment->updated_at)->format('d-m-Y H:i:s'),
                ];

                array_push($doctorPaymentRequestData, $data);
            }

            if (!is_null($doctorPaymentRequestData)) {
                return view('Admin.Transactions.doctor-payment-done', compact('doctorPaymentRequestData'));
            } else {
                return view('Admin.Transactions.doctor-payment-done');
            }
        }
    }

    public function getDoctorAmountToPay(Request $request, $requestId)
    {

        $doctorPaymentRequest = DoctorPaymentRequest::with('doctor')->where('id', $requestId)->first();
        if ($doctorPaymentRequest) {

            if ($doctorPaymentRequest->doctor) {
                if (!is_null($doctorPaymentRequest->doctor?->first_name) && !is_null($doctorPaymentRequest->doctor?->last_name)) {
                    $doctorFullName = $doctorPaymentRequest->doctor?->first_name . ' ' . $doctorPaymentRequest->doctor?->last_name;
                } else {
                    $doctorFullName =  $doctorPaymentRequest->doctor?->first_name;
                }
            }

            $data = [
                'id' => $doctorPaymentRequest->id,
                'doctor_name' => $doctorFullName ?? NULL,
                'request_amount' => $doctorPaymentRequest->request_amount,
            ];

            return view('Admin.Transactions.doctor-payment-modal', compact('data'));
        } else {
            return view('Admin.Transactions.doctor-payment-modal');
        }
    }

    public function payDoctorAmout(Request $request, $paymentRequestId)
    {

        $rules = [
            'transaction_number' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $doctorPaymentRequest = DoctorPaymentRequest::with('doctor')->where('id', $paymentRequestId)->first();
            if ($doctorPaymentRequest) {

                $doctorPaymentRequest->transaction_number = $request->transaction_number;
                $doctorPaymentRequest->status = 1;
                $doctorPaymentRequest->update();

                return response()->json(['status' => true, 'message' => 'Transaction Number Updated Successfully.']);
            } else {
                return response()->json(['status' => true, 'message' => 'Payment Request Not Found.']);
            }
        }
    }
}
