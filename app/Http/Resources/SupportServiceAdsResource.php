<?php

namespace App\Http\Resources;

use App\Models\SupportServiceAd;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportServiceAdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($this->resource[0]->whenLoaded('user'));
//        dd($this->resource);
        return [
            'ads' => $this->resource->map(function (SupportServiceAd $ad) {
                return [

                    'id' => $ad->id,
                    'title' => $ad->title,
                    'description' => $ad->description,
                    'support_service_id' => $ad->support_service_id,
                    'support_service' => $ad->supportService?->title,
                    'area_id' => $ad->area_id,
                    'area' => $ad->area->name,
                    'city_id' => $ad->city_id,
                    'city' => $ad->city->name,
                    'user_id' => $ad->user_id,
                    'user' => $ad->relationLoaded('user')?UserWithoutSubscription::make($ad->user):null,
//                    'user' => UserWithoutSubscription::make($ad->whenLoaded('user')),
                    'attachments' => AttachmentResource::collection($ad->attachments),
                ];
            }),
            'meta' => [
                "current_page" => $this->currentPage(),
                "first_page_url" => $this->getOptions()['path'] . '?' . $this->getOptions()['pageName'] . '=1',
                "prev_page_url" => $this->previousPageUrl(),
                "next_page_url" => $this->nextPageUrl(),
                "last_page_url" => $this->getOptions()['path'] . '?' . $this->getOptions()['pageName'] . '=' . $this->lastPage(),
                "last_page" => $this->lastPage(),
                "per_page" => $this->perPage(),
                "total" => $this->total(),
                "path" => $this->getOptions()['path'],
            ],
        ];
    }
}
