<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdCollection;
use App\Http\Resources\SingleAdResource;
use App\Models\Ad;
use App\Traits\ResponseTrait;

class StoryController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $ads = Ad::nearest()->story()->latest()->paginate(10);
        return $this->successResponse(data: new AdCollection($ads));

    }
    public function show(Ad $ad)
    {
        if($ad->is_story == 0){
            return $this->failedResponse(__('ad_is_not_a_story'));
        }
        $ad->storyViews()->firstOrCreate(['user_id' => auth()->id()]);
        $ad->loadCount('visits')->load(['user', 'options']);
//        dd($ad);
        return $this->successResponse('', ['ad' => SingleAdResource::make($ad)]);

    }
    public function toggleLike(Ad $ad)
    {
        if($ad->is_story == 0){
            return $this->failedResponse(__('ad_is_not_a_story'));
        }
        $user_id = auth()->id();
        $ad->toggleLike($user_id);

        return $this->successResponse($ad->isLikedBy($user_id) ? __("user_liked_this_story") : __("user_disliked_this_story") , ['is_liked'=>$ad->isLikedBy($user_id) ]);
    }
}
