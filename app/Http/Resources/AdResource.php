<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'id' => $this->id,
            'city' => $this->city?->name ?? "",
            'user_id' => $this->user_id,
            'is_nafath_verified' => $this->user->is_nafath_verified,
            'active' => (int) $this->active,
            'estate_type' => $this->estateType?->name ?? "",
            'ad_type' => $this->adType?->name ?? "",
            'main_type' => __($this->main_type),
            'location' => $this->location,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'price' => number_format((int) $this->price, 2),
            'min_price' => number_format((int) $this->min_price, 2),
            'max_price' => number_format((int) $this->max_price, 2),
            'area' => number_format((int) $this->area, 2),
            'min_area' => number_format((int) $this->min_area, 2),
            'max_area' => number_format((int) $this->max_area, 2),
            'special' => $this->special,
            'publish_date' => $this->created_at?->translatedFormat('d-m-Y'),
            'is_story' => $this->is_story,
            'attachment' => [get_file($this->attachments?->first()?->link)],
            'options'=>AdOptionResource::collection($this->options),
            'is_cancelled'=>(boolean)$this->is_cancelled,
            'reason_cancelled'=>new ReasonResource($this->reason_cancelled),
        ];
    }
}
