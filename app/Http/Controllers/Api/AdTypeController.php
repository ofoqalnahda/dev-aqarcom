<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdTypeResource;
use App\Models\AdType;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AdTypeController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        $types = server_cache(class_basename(AdType::class), 'long', fn() =>
            AdType::all()
        );

        return $this->successResponse('' , AdTypeResource::collection($types));
    }
}
