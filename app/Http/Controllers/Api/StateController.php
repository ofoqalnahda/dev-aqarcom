<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Models\State;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StateController extends Controller
{
    use ResponseTrait;
    public function __invoke(Request $request)
    {
        $states = server_cache(class_basename(State::class), 'long', fn() =>
                State::all()
        );

        return $this->successResponse(data: StateResource::collection($states));
    }
}
