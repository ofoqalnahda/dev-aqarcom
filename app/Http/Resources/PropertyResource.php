<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'min_value'     => $this->min_value,
            'max_value'     => $this->max_value,
            'type'          => $this->type,
            'show_outside'  =>$this->show_outside,
            'image'         =>get_file($this->image),
            'values_ar'        =>json_decode($this->values_ar),
            'values_en'        =>json_decode($this->values_en)
        ];
    }
}
