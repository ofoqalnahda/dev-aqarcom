<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReasonResource;
use App\Models\Reason;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        return $this->successResponse('' , ReasonResource::collection(Reason::all()));
    }
}
