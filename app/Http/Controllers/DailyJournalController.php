<?php

namespace App\Http\Controllers;

use App\Models\DailyJournal;
use Illuminate\Http\Request;
use Psy\Formatter\Formatter;
use App\Models\MasterEmotions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterEmotionsResource;
use App\Http\Resources\UserDailyJournalResouce;

class DailyJournalController extends Controller
{

    public function getAllEmotions(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $masterEmptions = MasterEmotions::where('status', 1)->get();
            if ($masterEmptions) {
                return response()->json(['status' => true, 'data' => MasterEmotionsResource::collection($masterEmptions)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Not Found']);
            }
        }
    }

    public function addDailyJournal(Request $request)
    {

        $rules = [
            'emotion_id' => 'required|integer',
            'date' => 'required|date',
            'message' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $patient = $user->patient;
                $doctor = $user->doctor;

                if ($patient) {
                    $patientId = $patient->id;
                }

                if ($doctor) {
                    $doctorId = $doctor->id;
                }

                if (!is_null($patientId) || !is_null($doctorId)) {
                    $dailyJournal = new DailyJournal();
                    $dailyJournal->patient_id = $patientId ?? NULL;
                    $dailyJournal->doctor_id = $doctorId ?? NULL;
                    $dailyJournal->emotion_id = $request->emotion_id;
                    $dailyJournal->journal_date = $request->date;
                    $dailyJournal->message = $request->message;
                    $dailyJournal->save();

                    return response()->json(['status' => true, 'message' => 'Daily Journal Added successfully']);
                }
            }
        }
    }

    public function getUserJournal(Request $request)
    {

        $user = $request->user();

        if ($user) {
            $patient = $user->patient;
            $doctor = $user->doctor;

            if($request->has('journal_date')){
                $requestDate =  Carbon::parse($request->journal_date)->format('Y-m-d');
                if ($patient) {
                    $dailyJournal = DailyJournal::with('emotion')->where('patient_id', $patient->id)->whereDate('journal_date','=',$requestDate)->orderBy('journal_date', 'DESC')->get();
                } else {
                    $dailyJournal = DailyJournal::with('emotion')->where('doctor_id', $doctor->id)->whereDate('journal_date','=',$requestDate)->orderBy('journal_date', 'DESC')->get();
                }
            }else{
                if ($patient) {
                    $dailyJournal = DailyJournal::with('emotion')->where('patient_id', $patient->id)->orderBy('journal_date', 'DESC')->get();
                } else {
                    $dailyJournal = DailyJournal::with('emotion')->where('doctor_id', $doctor->id)->orderBy('journal_date', 'DESC')->get();
                }
            }

            if ($dailyJournal->isNotEmpty()) {
                return response()->json(['status' => true, 'data' => UserDailyJournalResouce::collection($dailyJournal)]);
            }
        }
    }

    public function deleteUserJournal(Request $request, $dailyJournalId)
    {

        $user = $request->user();

        if ($user) {

            $dailyJournal = DailyJournal::where('id', $dailyJournalId)->first();
            if ($dailyJournal) {
                $dailyJournal->delete();
                return response()->json(['status' => true, 'message' => 'Journal Data Deleted Successfully']);
            }
        }
    }
}
