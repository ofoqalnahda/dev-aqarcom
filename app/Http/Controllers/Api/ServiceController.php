<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTrait;
    public function index()
    {
       $services = Service::query();

       if(request()->has('service_id')){
              $services = $services->where('id' , request()->service_id);
       }
       if(request('without') == 'users')
              $services = $services->without('users');
        $services = server_cache(class_basename(Service::class),'long',fn()=>
            $services->orderBy('sort')->get()
        );
        return $this->successResponse('' , ServiceResource::collection($services));
    }

}
