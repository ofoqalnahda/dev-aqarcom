<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\NeighborhoodResource;
use App\Models\Neighborhood;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NeighborhoodController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {

        $neighborhoods = server_cache(class_basename(Neighborhood::class), 'long', fn() =>
        Neighborhood::when(request()->city_id , function($query){
                return $query->where('city_id' ,request()->city_id );
                })->get()
        );

        return $this->successResponse('' , NeighborhoodResource::collection($neighborhoods));
    }
}
