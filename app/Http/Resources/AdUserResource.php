<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdResource;

class AdUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name ?? "",
            'phone'                     => ltrim($this->phone , '0'),
            'whatsapp'                  => ltrim($this->whatsapp , '0'),
            'image'                     =>get_file($this->image),
            'is_authentic'              => (int)$this->is_authentic,
            'is_nafath_verified'        => (int)$this->is_nafath_verified,
        ];
    }
}
