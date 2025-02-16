<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstateTypeResource;
use App\Models\EstateType;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EstateTypeController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        $types = server_cache(class_basename(EstateType::class), 'long', fn() =>
            EstateType::all()
        );
        return $this->successResponse('' , EstateTypeResource::collection($types));
    }
}
