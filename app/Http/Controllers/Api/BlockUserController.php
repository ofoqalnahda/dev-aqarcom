<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BlockUserController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $blockedUsers = auth()->user()->blockedUsers ;
        return $this->successResponse(data:UserResource::collection($blockedUsers));
    }


    public function store(User $user)
    {
        auth()->user()->blockedUsers()->syncWithoutDetaching($user->id);
        return $this->successResponse('blocked_successfully');
    }

    public function destroy(User $user)
    {
        $blockedUser = auth()->user()->blockedUsers()->detach($user->id);
        return $this->successResponse('unblocked_successfully');
    }
}
