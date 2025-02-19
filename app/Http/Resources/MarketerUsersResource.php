<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketerUsersResource extends JsonResource
{
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'status' => (boolean)$this->is_deserved,
            'user_id' => $this->user_id,
            'user_name' => $this->user?->name,
            'user_phone' => $this->user?->phone,
            'date' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i') :'',

        ];
    }
}
