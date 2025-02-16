<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserServiceRequest;
use App\Http\Resources\UserServiceResource;
use App\Models\UserSupportService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserSupportServiceController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $user_services = auth('api')->user()->supportService()->get();
        return $this->successResponse("",$user_services);
    }

    public function show(UserSupportService $userSupportService)
    {
//        if($userSupportService->user_id != auth('api')->id())
//            return $this->failedResponse(__("you can't access this service"));
        return $this->successResponse("",UserServiceResource::make($userSupportService));
    }

    public function store(UserServiceRequest $request)
    {
        auth('api')->user()->supportService()->firstOrCreate(
            [],
            [
                'support_service_id' => $request->support_service_id,
                'cities_ids' => $request->cities_ids,
                'keywords' => $request->keywords,
            ]
        );
        $user_service = auth('api')->user()->supportService()->first();
        return $this->successResponse(__('created_successfully'),$user_service);

    }

    public function update(UserServiceRequest $request, UserSupportService $userSupportService)
    {
        if (!$userSupportService || $userSupportService->user_id != auth('api')->id()){
            return $this->failedResponse('Not Allowed');
        }
        $userSupportService->update([
            'support_service_id' => $request->support_service_id,
            'cities_ids' => $request->cities_ids,
            'keywords' => $request->keywords,
        ]);
        $userSupportService = $userSupportService->refresh();
        return $this->successResponse(__("updated_successfully"),$userSupportService);

    }

    public function destroy(UserSupportService $userSupportService)
    {
        if (!$userSupportService || $userSupportService->user_id != auth('api')->id()){
            return $this->failedResponse('Not Allowed');
        }
        $userSupportService->delete();
        return $this->successResponse(__("deleted_successfully"),null);
    }

}
