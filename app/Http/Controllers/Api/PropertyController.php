<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    use ResponseTrait;
    public function index(?int $estateId = null , ?int $typeId = null)
    {
        $properties = Property::where([
            ['ad_type_id' , '=' , $typeId],
            ['estate_type_id' , '=' , $estateId]
        ])->get();
        return $this->successResponse('' ,PropertyResource::collection($properties));
    }
}
