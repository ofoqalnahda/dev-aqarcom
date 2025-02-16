<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'chats' => $this->collection->map(function($chat) {
                $receiver = $chat->receiver->id == auth()->id() ? $chat->sender : $chat->receiver;
                return [
                    'id' => $chat->id,
                    'title' => $chat->title??$chat->sender->name,
                    'user_id'   =>$chat->user_id,
                    'receiver_id'   =>$receiver->id,
                    'messages'   =>MessageResource::collection($chat->messages),
                    'receiver' => UserResource::make($receiver),
                ];
            }),
            'meta' => [
                "current_page" => $this->currentPage(),
                "first_page_url" =>  $this->getOptions()['path'].'?'.$this->getOptions()['pageName'].'=1',
                "prev_page_url" =>  $this->previousPageUrl(),
                "next_page_url" =>  $this->nextPageUrl(),
                "last_page_url" =>  $this->getOptions()['path'].'?'.$this->getOptions()['pageName'].'='.$this->lastPage(),
                "last_page" =>  $this->lastPage(),
                "per_page" =>  $this->perPage(),
                "total" =>  $this->total(),
                "path" =>  $this->getOptions()['path'],
            ],
        ];
    }
}
