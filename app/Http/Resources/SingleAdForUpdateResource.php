<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleAdForUpdateResource extends JsonResource
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
            'city' => $this->city?->name ?? "",
            'neighborhood' => $this->neighborhood?->name ?? "",
            'estate_area' => $this->estateArea?->name ?? "",
            'estate_type' => $this->estateType?->name ?? "",
            'ad_type' => $this->adType?->name ?? "",
            'usage_type' => new UsageTypeResource($this->usageType),
            'main_type' => __($this->main_type),
            'description' => $this->description,
            'address' => $this->address ?? "",
            'location' => $this->location ?? "",
            'lng' => $this->lng,
            'lat' => $this->lat,
            'active' => $this->active,
            'price' => number_format((int) $this->price, 2),
            'min_price' => number_format((int) $this->min_price, 2),
            'max_price' => number_format((int) $this->max_price, 2),
            'area' => number_format((int) $this->area, 2),
            'min_area' => number_format((int) $this->min_area, 2),
            'max_area' => number_format((int) $this->max_area, 2),
            'distance' => number_format((int) $this->distance, 2) . ' km',
            'special' => $this->special,
            'publish_date' => $this->created_at?->translatedFormat('d-m-Y') ?? "",
            'end_date' => $this->created_at?->addDays(30)->translatedFormat('d-m-Y') ?? "",
            'is_favourite' => (int) (auth('api')->user()?->favourite()->wherePivot('ad_id', $this->id)->count()),
            'visits_count' => $this->visits_count,
            //stories
            'is_story' => $this->is_story,
            'is_story_liked'=> $this->storyLikes?->where('user_id',auth('api')->id())->count(),
            'story_views' => $this->storyViews?->count(),
            'story_likes' => $this->storyLikes?->count(),
            'mortgage' => $this->mortgage ?? __('none'),
            'disputes' => $this->disputes ?? __('none'),
            'commitments' => $this->commitments ?? __('none'),
            'estate_notes' => $this->estate_notes ?? __('none'),
            'attachments' =>  AttachmentResource::collection($this->attachments->where('extension_file','!=','mp4')),
            'videos' =>  AttachmentResource::collection($this->videos),
            'advertiser_orientation' => $this->advertiserOrientation?->name ?? "",
            'advertiser_orientation_id' => $this->advertiser_orientation_id,
            'advertiser_type' => __($this->advertiser_type),
            'license_number' => $this->license_number ?? "",
            'delegation_number' => $this->delegation_number ?? "",
            'advertiser_registration_number' => $this->advertiser_registration_number ??  $this->license_number,
            'user' => AdUserResource::make($this->user),
            'properties' => AdOptionResource::collection($this->options),

        ];
    }
     
    
}
