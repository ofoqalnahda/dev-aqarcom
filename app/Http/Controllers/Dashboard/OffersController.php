<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessageFromAdmin;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Services\FcmNotificationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OffersController extends Controller
{
    public function index()
    {
        // check if chat has title and chat_messages are more than 1 message
        $chats = Chat::whereNotNull("title")
            ->with("lastMessage")
            // if messages count > 1
            ->whereHas("messages", function ($query) {
                $query->whereColumn("sender_id", "chats.receiver_id");
            })
            ->get();

//        dd($chats);

        return view('dashboard.offers.index' , compact('chats'));
    }

    public function show(Chat $chat)
    {
        $chat->load('messages');
//        dd($chat->messages);
        return view('dashboard.offers.show' , compact('chat'));
    }

    public function create()
    {
        return view('dashboard.offers.create',['types'=>NotificationController::getTypes()]);
    }

    public function store(Request $request)
    {
//        dd(array_keys(NotificationController::getTypes()));
        $request->validate([
            'title'     => ['required' , 'string' , 'max:255', 'min:3'],
            'message'   => ['required', 'string', 'max:255'],
            'to'        => ["required",Rule::in(array_keys(NotificationController::getTypes()))],
        ]);
//        dd($request->all());
        SendMessageFromAdmin::dispatch($request->message , $request->to, $request->title);

        return redirect()->route('dashboard.offers.index')->with('success' , __('messages.created'));
    }

    public function update(Request $request , Chat $chat)
    {
        $request->validate([
            'message'   => ['required', 'string', 'max:255'],
        ]);
//        dd($chat);
        $chat->messages()->create([
            'message'   => $request->message,
            'sender_id' => $chat->user_id,
            'chat_id'   => $chat->id,
        ]);

        $notificationService = new FcmNotificationService($chat->receiver , $chat);
        $notificationService->sendSingleNotification();
        return redirect()->route('dashboard.offers.show' , $chat->id)->with('success' , __('sent_successfully'));
    }
}
