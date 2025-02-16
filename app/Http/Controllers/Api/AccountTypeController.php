<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        return $this->successResponse('' , AccountTypeResource::collection(AccountType::all()));
    }
}
