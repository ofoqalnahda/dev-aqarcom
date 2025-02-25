<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'sender_id'=>$this->sender_id,
            'message'=>$this->message,
            'is_read'=>$this->is_read,
            'date'=>$this->created_at?$this->created_at->diffForHumans():'',
        ];
    }
}
