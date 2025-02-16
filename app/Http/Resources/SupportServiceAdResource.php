<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportServiceAdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($this->whenLoaded('user'));
        return [

                    'id' => $this->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'support_service_id' => $this->support_service_id,
                    'support_service' => $this->supportService?->title,
                    'area_id' => $this->area_id,
                    'area'=>$this->area->name,
                    'city_id' => $this->city_id,
                    'city'=>$this->city->name,
                    'user_id' => $this->user_id,
                    'user' => UserWithoutSubscription::make($this->whenLoaded('user')),
                    'attachments' => AttachmentResource::collection($this->attachments),

        ];
    }
}
