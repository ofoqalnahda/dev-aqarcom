<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationDataResource extends JsonResource
{
    public function toArray($request)
    {
        
        return [
            'phone' => $this->resource?->phone,
            'whatsapp' => $this->resource?->whatsapp,
            'email' => $this->resource?->email,
            'google_play' => $this->resource?->google_play,
            'app_store' => $this->resource?->app_store,
            'huawei_store' => $this->resource?->huawei_store,
            'facebook' => $this->resource?->facebook,
            'instagram' => $this->resource?->instagram,
            'twitter' => $this->resource?->twitter,
            'snapchat' => $this->resource?->snapchat,
            'linkedin' => $this->resource?->linkedin,
            'about_us' => $this->resource?->about_us,
            'terms' => $this->resource?->terms,
            'privacy' => $this->resource?->privacy,
            'agreement' => $this->resource?->agreement,
            'ad_conditions' => $this->resource?->ad_conditions,
            'app_commission' => $this->resource?->app_commission,
            'idea_policy' => $this->resource?->idea_policy,
            "description" => $this->resource?->description,
            "val_url" => $this->resource?->val_url,
            "val_image" => $this->resource? asset('uploads/'.$this->resource->val_image):null,
        ];
    }
}
