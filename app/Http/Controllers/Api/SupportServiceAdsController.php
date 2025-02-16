<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SupportServiceAdsRequest;
use App\Http\Resources\SupportServiceAdsResource;
use App\Models\SupportServiceAd;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupportServiceAdsController extends Controller
{
    public function index()
    {
        $supportServiceAds = server_cache(class_basename(SupportServiceAd::class), 'long', fn() =>
            SupportServiceAd::filter()->latest()->paginate(request('perPage') ?? 10)
        );
        return $this->successResponse('', new SupportServiceAdsResource($supportServiceAds));
    }

    public function show(SupportServiceAd $supportServiceAd)
    {
        return $this->successResponse('', $supportServiceAd);
    }

    public function store(SupportServiceAdsRequest $request)
    {
        $data = $request->validated();
        $attachments = Arr::pull($data, 'attachments');
        $supportServiceAd = DB::transaction(function () use ($data, $attachments) {
            $supportServiceAd = auth('api')->user()->supportServiceAds()->create($data);
            foreach ((array)$attachments as $file){
                $supportServiceAd->attachments()->create([
                    'path'=>file_uploader($file , 'support_service_ads'),
                    'mime_type'=>$file->getMimeType()
                ]);
            }

            $status = $this->checkUserBalance();
            if ($status instanceof \Illuminate\Http\JsonResponse)
                return $status;

            return $supportServiceAd;
        });

        if($supportServiceAd instanceof \Illuminate\Http\JsonResponse)
            return $supportServiceAd;

        $supportServiceAd->refresh();
        $supportServiceAd->load('attachments');
        return $this->successResponse(__('created_successfully'), $supportServiceAd);
    }

    public function update(SupportServiceAdsRequest $request, SupportServiceAd $supportServiceAd)
    {
        $data = $request->validated();
        $attachments = Arr::pull($data, 'attachments');
        $supportServiceAd = DB::transaction(function ()use ($supportServiceAd, $data, $attachments) {
            $supportServiceAd->update($data);
            $supportServiceAd->attachments()->delete();
            foreach ((array)$attachments as $file){
                $supportServiceAd->attachments()->create([
                    'path'=>file_uploader($file , 'support_service_ads'),
                    'mime_type'=>$file->getMimeType()
                ]);
            }
            return $supportServiceAd;
        });
        $supportServiceAd->refresh();
        $supportServiceAd->load('attachments');
        return $this->successResponse(__('updated_successfully'), $supportServiceAd);
    }

    public function destroy(SupportServiceAd $supportServiceAd)
    {
        if($supportServiceAd->user_id != auth('api')->id())
            return $this->failedResponse(__('not_authorized'), 403);
        $supportServiceAd->delete();

        return $this->successResponse(__('deleted_successfully'));
    }


    private function checkUserBalance(): bool|\Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $subscription = $user->subscription()->first();
        if ($subscription?->pivot->regular_ads >= 1) {
            $subscription->pivot->regular_ads = $subscription->pivot->regular_ads - 1;
            $subscription->pivot->save();
        } else if ($user->free_ads >= 1) {
            $user->decrement('free_ads', 1);
        } else {
            return $this->failedResponse(__('no_balance'));
        }
        return true;
    }
}
