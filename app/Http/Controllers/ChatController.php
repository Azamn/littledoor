<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use App\Http\Resources\MessagesResource;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Chat view.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'receiver_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $senderId = $user->id;

                $messages = $this->getUserMessages($senderId, $request->receiver_id) ?? NULL;

                $receiverData = User::with('media')->where('id', $request->receiver_id)->first();

                $receiverDetails = [
                    'id' => $receiverData->id,
                    'name' => $receiverData->name,
                    'image_url' => $receiverData->media->isNotEmpty() ? $receiverData->media->last()->getFullUrl() : NULL,
                ];

                return response()->json(['status' => true, 'data' => [
                    'messages' => $messages->isNotEmpty() ? MessagesResource::collection($messages) : NULL,
                    'recent_messeges' => $this->getRecentUsersWithMessage($senderId),
                    'receiver' => $receiverDetails,

                ]]);
            }
        }
    }

    public function getUserMessages(int $senderId, int $receiverId)
    {
        return Message::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->get();
    }

    public function getRecentUsersWithMessage(int $senderId): array
    {
        DB::statement("SET SESSION sql_mode=''");

        $recentMessages = Message::where(function ($query) use ($senderId) {
            $query->where('sender_id', $senderId)
                ->orWhere('receiver_id', $senderId);
        })
            ->groupBy('sender_id', 'receiver_id')
            ->select('sender_id', 'receiver_id', 'message')
            ->orderBy('id', 'desc')
            ->limit(30)
            ->get();

        return $this->getFilterRecentMessages($recentMessages, $senderId);
    }

    public function getFilterRecentMessages(Collection $recentMessages, int $senderId): array
    {
        $recentUsersWithMessage = [];
        $usedUserIds = [];
        foreach ($recentMessages as $message) {
            $userId = $message->sender_id == $senderId ? $message->receiver_id : $message->sender_id;
            if (!in_array($userId, $usedUserIds)) {
                $recentUsersWithMessage[] = [
                    'user_id' => $userId,
                    'message' => $message->message,
                    'created_at' => Carbon::parse($message->created_at)->toDateTimeString()
                ];
                $usedUserIds[] = $userId;
            }
        }

        foreach ($recentUsersWithMessage as $key => $userMessage) {

            $user = User::with('media')->where('id', $userMessage['user_id'])->first();

            $recentUsersWithMessage[$key]['name'] = $user->name ?? NULL;
            $recentUsersWithMessage[$key]['image_url'] = $user?->media?->isNotEmpty() ? $user?->media?->last()->getFullUrl() : NULL;
        }

        return $recentUsersWithMessage;
    }


    /**
     * Chat store
     *
     * @return \Inertia\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'receiver_id' => 'required|integer',
            'message' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $senderId = $user->id;

                $message = new Message();
                $message->sender_id = $senderId;
                $message->receiver_id = $request->receiver_id;
                $message->message = $request->message;
                $message->save();

                event(new MessageSent($message, $senderId, $request->receiver_id));
            }
        }
    }

    public function createChat(Request $request)
    {

        $rules = [
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $chatExist = Chat::where('sender_id', $request->patient_id)->where('receiver_id', $request->doctor_id)->first();
                if (!$chatExist) {

                    $chat = new Chat();
                    $chat->sender_id = $request->patient_id;
                    $chat->receiver_id = $request->doctor_id;
                    $chat->save();

                    return response()->json(['status' => true, 'message' => 'Chat Started']);
                }
            }
        }
    }

    public function getChat(Request $request)
    {

        $user = $request->user();

        if ($user) {
            $senderId = $user->id;

            $chats = Chat::where(function ($query) use ($senderId) {
                $query->where('sender_id', $senderId)
                    ->orWhere('receiver_id', $senderId);
            })
                ->groupBy('sender_id', 'receiver_id')
                ->select('sender_id', 'receiver_id')
                ->orderBy('id', 'desc')
                ->get();


            $recentUsersWithMessage = [];
            $usedUserIds = [];
            foreach ($chats as $chat) {
                $userId = $chat->sender_id == $senderId ? $chat->receiver_id : $chat->sender_id;
                if (!in_array($userId, $usedUserIds)) {
                    $recentUsersWithMessage[] = [
                        'user_id' => $userId,
                        'created_at' => Carbon::parse($chat->created_at)->toDateTimeString()
                    ];
                    $usedUserIds[] = $userId;
                }
            }

            foreach ($recentUsersWithMessage as $key => $userMessage) {

                $user = User::with('media')->where('id', $userMessage['user_id'])->first();

                $recentUsersWithMessage[$key]['name'] = $user->name ?? NULL;
                $recentUsersWithMessage[$key]['image_url'] = $user?->media?->isNotEmpty() ? $user?->media?->last()->getFullUrl() : NULL;
            }

            return response()->json(['status' => true, 'data' => $recentUsersWithMessage]);
        }
    }
}
