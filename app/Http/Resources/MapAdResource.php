<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapAdResource extends JsonResource
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
            'id'            => $this->id,
            'city'          => $this->city?->name ?? "",
            'estate_type'   =>$this->estateType?->name ?? "",
            'ad_type'       =>$this->adType?->name ?? "",
            'lng'           =>$this->lng,
            'lat'           =>$this->lat,
            'price'         =>number_format((int)$this->price ,2),
            'min_price'     =>number_format((int)$this->min_price,2),
            'max_price'     =>number_format((int)$this->max_price,2),
            'area'          =>number_format((int)$this->area,2),
            'min_area'      =>number_format((int)$this->min_area,2),
            'max_area'      =>number_format((int)$this->max_area,2),
            'special'       =>$this->special,
            'publish_date'  =>$this->created_at?->translatedFormat('d-m-Y'),
            'image'    => get_file($this->attachments->first()?->link),
        ];
    }
}
