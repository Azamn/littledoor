<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RazorPayTransactionLog;

class TransactionDetailController extends Controller
{
    public function getAllTransaction(Request $request)
    {

        $transcationData = RazorPayTransactionLog::with('patient', 'doctor')->orderBy('id', 'desc')->get();
        if ($transcationData) {
            $transactionDetails = [];
            foreach ($transcationData as $transaction) {

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
}
