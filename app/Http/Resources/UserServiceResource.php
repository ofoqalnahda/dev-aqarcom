<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

//        return parent::toArray($request);
//        dd($this->city);
        return [
            'id' => $this->id,
            'user_id'=> $this->user_id,

            'service_id' => $this->service_id,
            'city_id' => $this->city_id,
            'neighborhood_id' => $this->neighborhood_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'address' => $this->address,
            'description' => $this->description,
            'attachments' => AttachmentResource::collection($this->attachments),
            'service' => SupportServiceResource::make($this->service),
            'city' => CityResource::make($this->city),
            'area' => AreaResource::make($this->area),
            'neighborhood' => NeighborhoodResource::make($this->neighborhood),
            'user' => UserResource::make($this->user),
        ];

    }
}
