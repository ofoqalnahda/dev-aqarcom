<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdType;
use App\Models\EstateType;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {
        $estate_types = EstateType::all();
        $ad_types = AdType::all();

        $combinedTypes = [];

        foreach ($estate_types as $estate_type){
            foreach ($ad_types as $ad_type){
                $combinedTypes[]= [
                    'name' => $estate_type->name .__('for'). $ad_type->name,
                    'estate_type_id' => $estate_type->id,
                    'ad_type_id'   => $ad_type->id
                ];
            }
        }
        return $this->successResponse(data:$combinedTypes);
    }
}
