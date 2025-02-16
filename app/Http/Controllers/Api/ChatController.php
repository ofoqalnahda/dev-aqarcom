<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\MessageResource;
use App\Services\FcmNotificationService;
use App\Models\Chat;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $chats = Chat::latest()->wherehas('receiver')->wherehas('sender')->where(function($q){
            $q->where('user_id' , auth()->id())->orWhere('receiver_id' , auth()->id());
        } )->with('messages')->paginate(15);
        // dd($chats, auth()->id());
            
        $data = (new ChatCollection($chats))->toArray('');

        return response()->json([
            'success'   => true,
            'message'   => '',
            'data'      => $data['chats'],
            'meta'      => $data['meta'],
        ]);
    }

    public function store(Request $request)
    {
        $messageData = $request->validate([
            'receiver_id'   => ['required', 'exists:users,id'],
            'message'   => ['required'],
//            'chat_id'   => 'nullable|exists:chats,id'
        ]);

        if(auth('api')->id() == $request->receiver_id)
            return $this->failedResponse(__('not_allowed'));

        $receiver = User::find($request->receiver_id);
        if(!$receiver->receive_messages)
            return $this->failedResponse(__('no_messages'));

        $chat = Chat::where([['user_id' , '=' , auth()->id()],['receiver_id' , '=' , $messageData['receiver_id']]])
            ->orWhere([['receiver_id' , '=' , auth()->id()],['user_id' , '=' , $messageData['receiver_id']]])
        ->orWhere([
            ['id' , $messageData['receiver_id']],
            ['receiver_id' , auth()->id()],
            ['title' , '!=', null]

        ])
        ->first();

        if(!$chat)
            $chat = Chat::create([
                'user_id'   => auth()->id(),
                'receiver_id' => $messageData['receiver_id']
            ]);

        $chat->messages()->create([
            'sender_id' => auth()->id(),
            'message'   => $messageData['message']
        ]);

        $notificationService = new FcmNotificationService($receiver , $chat);
        $notificationService->sendSingleNotification();

        return $this->successResponse(__('sent_successfully'));
    }

    public function show($receiver_id)
    {
        $chat = Chat::where([['user_id' , '=' , auth()->id()],['receiver_id' , '=' , $receiver_id]])->orWhere([['receiver_id' , '=' , auth()->id()],['user_id' , '=' , $receiver_id]])->
        orWhere([
            ['id' , $receiver_id],
            ['receiver_id' , auth()->id()],
            ['title' , '!=', null]

        ])
            ->first();

        if(!$chat)
            return $this->successResponse(data:[]);


        return $this->successResponse(data:MessageResource::collection($chat->messages));
    }
}
