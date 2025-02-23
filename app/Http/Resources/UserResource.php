<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {

//        dd($this->id,auth('api')->id(),$this->followers->where('pivot.follower_id', auth('api')->id())->count());
//        $subscription = $this->subscription->where('pivot.is_active', 1)->first();
//        $this->load('followers');

        return [
            'id' => $this->id,
            'token' => $this->token ?? "",
            'name' => $this->name ?? "",
            'email' => $this->email ?? "",
            'phone' => ltrim($this->phone, '0'),
            'whatsapp' => ltrim($this->whatsapp, '0'),
            'code' =>'',
            'is_marketer' =>$this->is_marketer(),
            'image' => get_file($this->image),
            'is_verified' => (int) $this->is_verified,
            'is_nafath_verified' => (int) $this->is_nafath_verified,
            'last_login' => $this->last_login?\Carbon\Carbon::parse($this->last_login)->diffForHumans() : "",
            'is_followed' => (int) (auth('api')->user()?->followers->where('pivot.follower_id', $this->id)->count()),
//            'is_followed' => $this->followers->where('pivot.follower_id', auth('api')->id())->count(),
            'is_authentic' => (int) $this->is_authentic,
            'id_have_support_service' => $this->supportService()->count() >= 1 ,
            'pending_authentication' => (int) $this->pending_authentication,
            'receive_messages' => (int) $this->receive_messages,
            'receive_notification' => (int) $this->receive_notification,
            'free_ads' => (int) $this->free_ads,
            'account_type' => $this->accountType?->name,
            'account_type_id' => $this->account_type_id,
            'identity_owner_name' => $this->identity_owner_name,
            'identity_number' => $this->identity_number,
            'commercial_owner_name' => $this->commercial_owner_name,
            'commercial_name' => $this->commercial_name,
            'commercial_number' => $this->commercial_number,
            'commercial_image' => get_file($this->commercial_image),
            'identity_image' => get_file($this->identity_image),
            'val_license' => $this->val_license ? get_file($this->val_license) : null,
            'can_story' => $this->subscription->where('pivot.is_active', 1)->first()?->id == 9  && $this->ads?->where('is_story', 1)->count() < 1 ? 1 : 0,
            'city'=> CityResource::make($this->city),
            'subscription' => UserSubscriptionResource::customCollection($this->subscription->where('pivot.is_active', 1), $this->services->groupby('pivot.city_id'),$this->supportService),
        ];
    }
}
