<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Http\Resources\CityResource;
use App\Models\Area;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        $areas = server_cache( class_basename(Area::class) , 'long', fn() =>
                Area::all()
        );


        return $this->successResponse('' , AreaResource::collection($areas));
    }
}
