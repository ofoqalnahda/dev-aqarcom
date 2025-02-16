<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subscription = $this->subscription()->first();
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'image' => get_file($this->image),
            'lng'   => $subscription->pivot->lng,
            'lat'   => $subscription->pivot->lat,
        ];
    }
}
