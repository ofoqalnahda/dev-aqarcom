<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {
        $cities = server_cache(class_basename(City::class), "long", fn() =>
            City::when(request()->area_id , function($query){
                return $query->where('area_id' ,request()->area_id );
            })->get()
        );
        return $this->successResponse('' , CityResource::collection($cities));
    }
}
