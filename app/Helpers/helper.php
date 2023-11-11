<?php

use App\Models\DoctorPaymentRequest;

function generateUniqueUserId()
{
    $currentYear = date('y');
    $currentMonth = date('m');
    $currentDate = date('d');
    $randomNumericString = rand(100000, 999999);
    $uniquePaymentRequestId = $currentYear . $currentMonth . $randomNumericString . $currentDate;
    if (strlen($uniquePaymentRequestId) > 12) {
        $uniqueRequestId = substr($uniquePaymentRequestId, 0, 12);
    } else {
        $lengthOfId = strlen($uniquePaymentRequestId);
        $requiredLength = 12 - $lengthOfId;
        if ($requiredLength > 0) {
            $uniqueRequestId = $uniquePaymentRequestId . random_int(1, 10000, $requiredLength);
        }
    }
    $isProperUniqueID = DoctorPaymentRequest::where('request_transaction_number', $uniqueRequestId)->exists();
    if (!$isProperUniqueID) {
        generateUniqueUserId();
    }
    return $uniqueRequestId;
}
