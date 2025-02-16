<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWithoutSubscription extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'token' => $this->token ?? "",
            'name' => $this->name ?? "",
            'email' => $this->email ?? "",
            'phone' => ltrim($this->phone, '0'),
            'whatsapp' => ltrim($this->whatsapp, '0'),
            'code' => $this->code,
            'image' => get_file($this->image),
            'is_verified' => (int) $this->is_verified,
            'is_nafath_verified' => (int) $this->is_nafath_verified,
            'last_login' => $this->last_login?\Carbon\Carbon::parse($this->last_login)->diffForHumans() : "",
            'is_followed' => (int) (auth('api')->user()?->followers()->wherePivot('follower_id', $this->id)->count()),
            'is_authentic' => (int) $this->is_authentic,
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
//            'can_story' => $subscription?->id == 9  && $this->ads?->where('is_story', 1)->count() < 1 ? 1 : 0,
            'city'=> CityResource::make($this->city),
//            'subscription' => UserSubscriptionResource::customCollection($this->subscription()->wherePivot('is_active', 1)->get(), $this->services()->get()->groupby('pivot.city_id')),
        ];
    }
}
