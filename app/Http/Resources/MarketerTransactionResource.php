<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketerTransactionResource extends JsonResource
{
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'title' => __('draws_'.$this->transaction_type.'_'.$this->status,['amount'=>$this->amount]),
            'amount' => $this->amount,
            'status' => $this->status,
            'type' =>$this->transaction_type,
            'date' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i') :'',
        ];
    }
}
