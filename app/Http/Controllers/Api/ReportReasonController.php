<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportReasonResource;
use App\Models\ReportReason;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReportReasonController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {
        return $this->successResponse(data:ReportReasonResource::collection(ReportReason::all()));
    }
}
