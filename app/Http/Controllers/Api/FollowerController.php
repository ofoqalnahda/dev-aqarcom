<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        return $this->successResponse('' , UserResource::collection(auth()->user()->followers));
    }

    public function follow(User $user)
    {
        $follower = auth()->user();
        $follower->followers()->syncWithoutDetaching($user->id);
        return $this->successResponse(__('followed_successfully'));
    }

    public function unFollow(User $user)
    {
        $follower = auth()->user();
        $follower->followers()->detach($user->id);
        return $this->successResponse(__('unfollowed_successfully'));
    }
}
