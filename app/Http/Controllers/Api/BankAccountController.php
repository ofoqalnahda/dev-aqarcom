<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankAccountResource;
use App\Models\BankAccount;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {
        $bankAccounts = BankAccount::all();
        return $this->successResponse(data:BankAccountResource::collection($bankAccounts));
    }
}
