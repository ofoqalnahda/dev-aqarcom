<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'ads' => $this->collection->map(function($ad) {
                return [
                    'id'            => $ad->id,
                    'city'          => $ad->city?->name ?? "",
                    'neighborhood'  =>'',// $this->neighborhood?->name,
                    'estate_area'   =>'',//$this->estateArea?->name,
                    'estate_type'   =>$ad->estateType?->name ?? "",
                    'ad_type'       =>$ad->adType?->name ?? "",
                    'usage_type'    =>'',//$this->usageType?->name,
                    'main_type'     =>__($ad->main_type),
                    'description'   =>$ad->description,
                    'address'       =>$ad->address,
                    'location'      =>$ad->location,
                    'lng'           =>$ad->lng,
                    'lat'           =>$ad->lat,
                    'active'       =>$ad->active,
                    'price'         =>number_format((int)$ad->price ,2),
                    'min_price'     =>number_format((int)$ad->min_price,2),
                    'max_price'     =>number_format((int)$ad->max_price,2),
                    'area'          =>number_format((int)$ad->area,2),
                    'min_area'      =>number_format((int)$ad->min_area,2),
                    'max_area'      =>number_format((int)$ad->max_area,2),
                    'distance'      =>number_format((int)$ad->distance,2) . ' km',
                    'special'       =>$ad->special,
                    'publish_date'  =>$ad->created_at?->translatedFormat('d-m-Y'),
                    'end_date'      =>'',//$this->created_at?->addDays(30)->translatedFormat('d-m-Y'),
//                    'is_favourite'  => (int)(auth('api')->user()?->favourite()->wherePivot('ad_id' , $ad->id)->count()),
                    'is_favourite'  => $ad->favourite->where('pivot.user_id',auth('api')->id())->count(),
                    'visits_count'  =>(int)$ad->visits_count,
                    'mortgage'      =>$ad->mortgage ?? __('none'),
                    'disputes'      =>$ad->disputes ?? __('none'),
                    'commitments'   =>$ad->commitments ?? __('none'),
                    'estate_notes'  =>$ad->estate_notes ?? __('none'),
                    'attachment'    => appendPathToImages($ad->attachments->pluck('link')?->toArray()),
                    'advertiser_orientation'    =>'',//$this->advertiserOrientation?->name,
                    'advertiser_type'           =>$ad->advertiser_type,
                    'license_number' =>$ad->license_number,
                    'delegation_number' =>$ad->delegation_number,
                    'advertiser_registration_number'   =>$ad->license_number,//$this->advertiser_registration_number,
                    'user'    =>  AdUserResource::make($ad->user),
                    'properties'    => [], //AdOptionResource::collection($this->options)
                    'is_story'=>$ad->is_story,
//                    'story_views'=>$ad->storyViews?->count(),
//                    'story_likes'=>$ad->storyLikes?->count(),
                    'story_views'=>$ad->story_views_count,
                    'story_likes'=>$ad->story_likes_count,

                    'options'=>AdOptionResource::collection($ad->options)



                ];
            }),
            'meta' => [
                "current_page" => $this->currentPage(),
                "first_page_url" =>  $this->getOptions()['path'].'?'.$this->getOptions()['pageName'].'=1',
                "prev_page_url" =>  $this->previousPageUrl(),
                "next_page_url" =>  $this->nextPageUrl(),
                "last_page_url" =>  $this->getOptions()['path'].'?'.$this->getOptions()['pageName'].'='.$this->lastPage(),
                "last_page" =>  $this->lastPage(),
                "per_page" =>  $this->perPage(),
                "total" =>  $this->total(),
                "path" =>  $this->getOptions()['path'],
            ],
        ];
    }
}
