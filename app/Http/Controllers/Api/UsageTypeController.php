<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdTypeResource;
use App\Http\Resources\UsageTypeResource;
use App\Models\AdType;
use App\Models\UsageType;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UsageTypeController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        $types = server_cache(class_basename(UsageType::class), 'long', fn() =>
            UsageType::all()
        );

        return $this->successResponse('' , UsageTypeResource::collection($types));
    }
}
