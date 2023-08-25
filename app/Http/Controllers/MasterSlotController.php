<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorTimeSlot;
use App\Models\MasterTimeSlot;
use App\Models\DoctorSessionCharge;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DoctorTimeSlotResource;
use App\Http\Resources\MasterTimeSlotResource;
use App\Http\Resources\DoctorSessionChargeResource;

class MasterSlotController extends Controller
{

    public function getTimeSlot(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $masterTimeSlot = MasterTimeSlot::where('status', 1)->get();

            if ($masterTimeSlot->isNotEmpty()) {
                return response()->json(['status' => true, 'data' => MasterTimeSlotResource::collection($masterTimeSlot)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Not Found']);
            }
        }
    }

    public function getDoctorSlot(Request $request)
    {

        $user = $request->user();

        if ($user) {
            $doctor = $user->doctor;

            if ($doctor) {

                $doctorSession = DoctorSessionCharge::where('doctor_id', $doctor->id)->first();
                if (!is_null($doctorSession)) {
                    $sessionChargeData = $doctorSession->session_amount;
                }

                $doctorTimeSlot = DoctorTimeSlot::with('timeSlot')->where('doctor_id', $doctor->id)->get();
                if ($doctorTimeSlot->isNotEmpty()) {

                    $doctorSlotTime = DoctorTimeSlotResource::collection($doctorTimeSlot) ?? NULL;
                }

                return response()->json([
                    'status' => true, 'data' => [
                        'session_charge' => $sessionChargeData ?? NULL,
                        'consultancy_status' => $doctor?->consultancy_status ?? NULL,
                        'slot_time' => $doctorSlotTime ?? NULL
                    ]
                ]);
            } else {
                return response()->json(['status' => false, 'message' => 'Doctor Data Not Found']);
            }
        }
    }

    public function createDoctorTimeSlot(Request $request)
    {

        $rules = [
            'doctor_id' => 'required|integer',
            'time_slot.*.day_id' => 'required|integer',
            'time_slot.*.all' => 'sometimes|required',
            'time_slot.*.slot_ids.*' => 'sometimes|required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                if ($request->has('time_slot')) {

                    $doctorTimeSlotExists = DoctorTimeSlot::where('doctor_id', $request->doctor_id)->get();
                    if ($doctorTimeSlotExists->isNotEmpty()) {
                        foreach ($doctorTimeSlotExists as $doctorTime) {
                            $doctorTime->delete();
                        }
                    }

                    foreach ($request->time_slot as $timeSlot) {
                        if (isset($timeSlot['all']) && !is_null($timeSlot['all']) && $timeSlot['all'] == 1) {
                            $slotIds = MasterTimeSlot::where('status', 1)->pluck('id')->toArray();
                        } else {
                            $slotIds = $timeSlot['slot_ids'];
                        }

                        if (!is_null($slotIds)) {

                            foreach ($slotIds as $slotId) {
                                $doctorTimeSlot = new DoctorTimeSlot();
                                $doctorTimeSlot->doctor_id = $request->doctor_id;
                                $doctorTimeSlot->master_days_id = $timeSlot['day_id'];
                                $doctorTimeSlot->time_slot_id = $slotId;
                                $doctorTimeSlot->save();
                            }
                        }
                    }

                    return response()->json(['status' => true, 'message' => 'Doctor Slot Save Successfully']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Unauthorized User']);
            }
        }
    }

    public function deleteDoctorSlot(Request $request, $doctorSlotId)
    {

        $doctorTimeSlot = DoctorTimeSlot::where('id', $doctorSlotId)->first();
        if (!is_null($doctorTimeSlot)) {
            $doctorTimeSlot->delete();
            return response()->json(['status' => false, 'message' => 'Doctor Slot Delete Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Not Found']);
        }
    }
}
