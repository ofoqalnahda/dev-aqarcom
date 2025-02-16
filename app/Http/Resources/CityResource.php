<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
//        dd($this);
        return [
            'id'    =>$this->id,
            'name'  => $this->name,
//            'area'  => $this->area->name,
//            'area_id'  => $this->area->id,
            'area_id'  => $this->area_id,
            'lat'   => $this->lat,
            'lng'   => $this->lng,
            'real_lat'   => $this->real_lat,
            'real_lng'   => $this->real_lng
        ];
    }
}
