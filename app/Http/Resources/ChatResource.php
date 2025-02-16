<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $receiver = $this->receiver->id == auth()->id() ? $this->sender : $this->receiver;
        return [
            'id' => $this->id,
            'user_id'   =>$this->user_id,
            'receiver_id'   =>$receiver->id,
            'messages'   =>MessageResource::collection($this->messages),
            'receiver' => UserResource::make($receiver),
        ];
    }
}
