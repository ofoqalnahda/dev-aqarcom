<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\SupportService;
use App\Models\UserSupportService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    protected static ?Collection $services;
    protected static ?Collection $cities;
    protected static ?Collection $supportServices;

    public function toArray($request)
    {
        return [
            'subscription_id' => $this->id,
            'name' => $this->name,
            'subscription_location' => $this->location,
            'regular_ads' => $this->pivot->regular_ads,
            'special_ads' => $this->pivot->special_ads,
            'about' => $this->pivot->about,
            'city_id' => $this->pivot->city_id,
            'gallery' => appendPathToImagesGallery(json_decode($this->pivot->gallery ?? "")),
            'location' => $this->pivot->location,
            'lng' => $this->pivot->lng,
            'lat' => $this->pivot->lat,
            'social' => [
                'facebook' => $this->pivot->facebook,
                'facebook_status' => (int) $this->pivot->facebook_status,
                'instagram' => $this->pivot->instagram,
                'instagram_status' => (int) $this->pivot->instagram_status,
                'twitter' => $this->pivot->twitter,
                'twitter_status' => (int) $this->pivot->twitter_status,
                'snapchat' => $this->pivot->snapchat,
                'snapchat_status' => (int) $this->pivot->snapchat_status,
                'linkedin' => $this->pivot->linkedin,
                'linkedin_status' => (int) $this->pivot->linkedin_status,
                'website' => $this->pivot->website,
                'website_status' => (int) $this->pivot->website_status,
            ],
            'end_date' => $this->pivot->end_date,
            'premium' => $this->premium,
            'service_city' => self::$services
                ->mapToGroups(function ($item, $key) {
                    return [
                        $key => ServiceWithoutUserResource::collection($item),
                    ];
                })
                ->map(function ($services, $city_id) {
                    return [
                        'city_id' => empty($city_id) ? null : $city_id,
                        'city'=> self::$cities->where('id', $city_id)->first()?->name,
                        'services' => $services->first(),
                    ];
                })
                ->values(),
            "support_service"=>self::$supportServices?->first(),
];

    }

    public static function customCollection($resource, $services,$supportServices): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        //you can add as many params as you want.
        self::$services = $services;
        self::$cities = City::all();
        self::$supportServices = $supportServices;
        return parent::collection($resource);
    }
}
