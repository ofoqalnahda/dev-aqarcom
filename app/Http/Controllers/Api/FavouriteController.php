<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return $this->successResponse('',AdResource::collection(auth()->user()->favourite));
    }

    public function store(int $adId)
    {
        auth()->user()->favourite()->syncWithoutDetaching([$adId]);
        return $this->successResponse(__('added_successfully'));
    }

    public function destroy(int $adId)
    {
        auth()->user()->favourite()->detach([$adId]);
        return $this->successResponse(__('removed_successfully'));
    }
}
