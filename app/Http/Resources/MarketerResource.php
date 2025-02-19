<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketerResource extends JsonResource
{
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'code' =>$this->code,
            'balance' => (float)$this->balance,
            'total_withdrawals' => (float)$this->total_withdrawals,
            'total_deposits' => (float)$this->total_deposits,
            'total_deposits_pending' => (float)$this->total_deposits_pending,
            'count_subscription' => $this->transactions_count,
            'transactions' => MarketerTransactionResource::collection($this->draws()->Show()->orderBy('updated_at', 'desc')->limit(3)->get()),
        ];
    }
}
