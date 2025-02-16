<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertiserOrientationResource;
use App\Http\Resources\AreaResource;
use App\Models\AdvertiserOrientation;
use App\Models\Area;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AdvertiserOrientationController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {
        $types = server_cache(class_basename(AdvertiserOrientation::class), 'long', fn() =>
            AdvertiserOrientation::all()
        );
        return $this->successResponse('' , AdvertiserOrientationResource::collection($types));
    }
}
