<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' =>$this->name,
            'image' => get_file($this->image),
            'account_number' => $this->account_number,
            'iban'  => $this->iban
        ];
    }
}
