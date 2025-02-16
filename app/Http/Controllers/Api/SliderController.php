<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    function __invoke()
    {
        $sliders = server_cache(class_basename(Slider::class),'long',fn()=>
            Slider::all()
        );
        return $this->successResponse('', $sliders);
    }
}
