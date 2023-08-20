<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorTimeSlot;
use App\Models\MasterTimeSlot;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DoctorTimeSlotResource;
use App\Http\Resources\MasterTimeSlotResource;

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

                $doctorTimeSlot = DoctorTimeSlot::with('timeSlot')->where('doctor_id', $doctor->id)->get();
                if ($doctorTimeSlot->isNotEmpty()) {
                    return response()->json(['status' => true, 'data' => DoctorTimeSlotResource::collection($doctorTimeSlot)]);
                } else {
                    return response()->json(['status' => false, 'message' => 'DoctorTime Slot Data Not Found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Doctor Data Not Found']);
            }
        }
    }

    public function createDoctorTimeSlot(Request $request)
    {

        $rules = [
            'available_for_consultancy' => 'required',
            'doctor_id' => 'required|integer',
            'time_slot.*.day' => 'required|integer',
            'time_slot.*.all' => 'sometimes|required',
            'time_slot.*.slot_ids.*' => 'sometimes|required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                if ($request->has('time_slot_ids')) {
                    foreach ($request->time_slot_ids as $timeSlot) {
                        $doctorTimeSlot = new DoctorTimeSlot();
                        $doctorTimeSlot->doctor_id = $request->doctor_id;
                        $doctorTimeSlot->time_slot_id = $timeSlot;
                        $doctorTimeSlot->save();
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
