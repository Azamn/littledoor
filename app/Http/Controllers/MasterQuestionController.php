<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterQuestion;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterQuestionResource;

class MasterQuestionController extends Controller
{
    public function getAll(Request $request)
    {

        $user = $request->user();
        if ($user) {
            $masterQuestions = MasterQuestion::where('status', 1)->get();
            if ($masterQuestions) {
                return response()->json(['status' => true, 'data' => MasterQuestionResource::collection($masterQuestions)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Questions Not Found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $user = $request->user();

            if ($user) {

                $masterQuestions = new MasterQuestion();
                $masterQuestions->name = $request->name;
                $masterQuestions->status = 1;
                $masterQuestions->save();

                return response()->json(['status' => true, 'message' => 'Question Save Successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Authenticated.']);
            }
        }
    }

    public function createThroughAdmin(Request $request)
    {

        $rules = [
            'questions.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            if ($request->has('questions')) {
                foreach ($request->questions as $key => $question) {
                    $masterQuestions = new MasterQuestion();
                    $masterQuestions->name = $question;
                    $masterQuestions->status = 1;
                    $masterQuestions->save();
                }

                return response()->json(['status' => true, 'message' => 'Question Added Successfully.']);
            }
        }
    }

    public function getAllThroughAdmin(Request $request)
    {

        $masterQuestionsData = [];
        $masterQuestions = MasterQuestion::get();

        foreach ($masterQuestions as $masterQuestion) {
            $data = [
                'id' => $masterQuestion?->id,
                'name' => $masterQuestion?->name,
                'status' => $masterQuestion?->status,
            ];

            array_push($masterQuestionsData, $data);
        }

        return view('Admin.Questions.questions-list', compact('masterQuestionsData'));
    }

    public function delete(Request $request)
    {

        $masterQuestion = MasterQuestion::where('id', $request->question_id)->first();

        if ($masterQuestion) {
            $masterQuestion->delete();
            return response()->json(['status' => true, 'message' => 'Question Deleted Successfully.']);
        }
    }

    public function changeQuestionStatus(Request $request)
    {

        $masterQuestion = MasterQuestion::where('id', $request->question_id)->first();
        if ($masterQuestion) {
            $masterQuestion->status = !$masterQuestion->status;
            $masterQuestion->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
    }

    public function edit(Request $request, $questionId)
    {

        $masterQuestion = MasterQuestion::where('id', $questionId)->first();
        if ($masterQuestion) {
            $questionData = [];

            $questionData = [
                'id' => $masterQuestion?->id,
                'name' => $masterQuestion?->name,
            ];

            return view('Admin.Questions.questions-edit', compact('questionData'));
        }
    }

    public function update(Request $request, $questionId)
    {
        $rules = [
            'question' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $masterQuestion = MasterQuestion::where('id', $questionId)->first();
            if ($masterQuestion) {

                if ($request->has('question')) {
                    $masterQuestion->name = $request->question;
                    $masterQuestion->update();
                }

                return response()->json(['status' => true, 'message' => 'Question Update Successfully']);
            }
        }
    }
}
