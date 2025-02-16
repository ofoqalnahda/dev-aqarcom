<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportServiceResource;
use App\Http\Resources\UserServiceResource;
use App\Models\Blog;
use App\Models\SupportService;
use App\Models\Setting;
use App\Models\UserSupportService;
use App\Traits\ResponseTrait;

class SupportServiceController extends Controller
{
    use ResponseTrait;
    public function index()
    {

        $services = SupportService::when(request()->has('service_id'),function ($q){
                $q->where('id' , request()->service_id);
            })
            ->when(request()->has('without') && request()->has('without')=='users' ,fn($q)=>
                $q->without('users')
            );
         $services->when(request()->user_id , function ($q){
                $q->wherehas('users' ,function ($q2){
                        $q2->where('users.id', request()->user_id);
                    });
            });
        $services = server_cache(class_basename(SupportService::class),'long',fn()=>
            $services->orderBy('sort')->get()
        );


        return $this->successResponse('' , SupportServiceResource::collection($services));
    }
    public function status()
    {

        $data['status_support_services'] = Setting::first()->status_support_services == 1 ? true : false;

        return $this->successResponse('' , $data);
    }

}
