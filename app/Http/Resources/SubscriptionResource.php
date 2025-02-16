<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'            => $this->id ,
            'name'          => $this->name ,
            'regular_ads'   => $this->regular_ads ,
            'special_ads'   => $this->special_ads,
            'premium'       => (int)$this->premium,
            'location'      => (int)$this->location,
            'duration'      => $this->duration . ' ' . __('days'),
            'price'         => number_format($this->price , 2),
            'old_price' =>$this->old_price ? number_format($this->old_price , 2) : null,
            'description'   => $this->description,
            'features'      => ((array)json_decode((string)$this->features))[app()->getLocale()] ?? []
        ];
    }
}
