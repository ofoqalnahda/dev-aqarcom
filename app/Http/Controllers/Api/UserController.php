<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Requests\Api\VerifyUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\SupportServiceAdResource;
use App\Http\Resources\SupportServiceAdsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\AdResource;
use App\Models\AccountType;
use App\Models\State;
use App\Models\User;
use App\Scopes\ActiveAdScope;
use App\Http\Controllers\OTPController;
use App\Services\PaymentService;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CompanyResource;
class UserController extends Controller
{
    use ResponseTrait;
    public function show(User $user)
    {
        return $this->successResponse(data:UserResource::make($user));
    }


    public function update(UpdateUserRequest $request)
    {
        $userData = $request->safe()->except(['password' , 'image']);

        if($request->image)
            $userData['image'] = image_uploader_without_resize($request->image , 'users' , auth()->user()->image);
        $user = auth()->user();
        $user->update($userData);
        $user->token = $user->createToken('token')->plainTextToken;

        return $this->successResponse(__('updated_successfully') , UserResource::make($user));
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        $user =auth()->user();
        if(!Hash::check($request->old_password , $user->password))
            return $this->failedResponse(__('wrong_password'));

        if($request->new_password == $request->old_password)
            return $this->failedResponse(__('repeated_password'));

        $user->password = bcrypt($request->new_password) ;
        $user->save();
        return $this->successResponse(__('updated_successfully'));
    }

    public function verifyUser(VerifyUserRequest $request)
    {
        $verificationData = $request->safe()->except(['commercial_image' , 'identity_image' , 'receipt' , 'payment_method']);
        $user = auth()->user();

        if($request->identity_image)
            $verificationData['commercial_image'] =  image_uploader_without_resize($request->identity_image , 'verifications');

        if($request->commercial_image)
            $verificationData['identity_image'] = image_uploader_without_resize($request->commercial_image, 'verifications');


        if($user->pending_authentication){
            $user->update($verificationData);
            return $this->successResponse(__('verified_successfully'));
        }





        $account_type = AccountType::find($request->account_type_id);

        if($request->payment_method == 'bank'){
            $verificationData['pending_authentication'] = 1;
            $verificationData['payment_id'] = PaymentService::createBankPayment(file_uploader($request->receipt , 'payments'));

            $message = "يوجد طلب توثيق جديد من العميل رقم : " . $user->id;
            \App\Services\AdminNotification::create($message , route('dashboard.authenticationRequests.index',[],false));

        }else{
            $url =route('payment.store' , ['verification' , auth('api')->id()]);
            $user = auth()->user();
            $user->update($verificationData);

            return $this->successResponse(data:[
                'url' => route('payment.create' , [$account_type->price , 'url' => $url])
            ]);
        }
        $user = auth()->user();
        $user->update($verificationData);

        return $this->successResponse(__('verified_successfully'));

    }


    public function companies()
    {
        $users = User::whereRelation('subscription' , 'lat' , '<>' , null)->when(request()->state_id , function ($q){
            $state = State::find(request()->state_id);
            if($state)
                $q->whereRelationIn('subscription' , 'city_id' , $state->cities()->pluck('id'));

        })->get();
        return $this->successResponse(data:CompanyResource::collection($users));
    }

    public function ads()
    {
        $ads = auth()->user()->ads()->withoutGlobalScope(ActiveAdScope::class)->withAll()->orderBy('refresh_date' , 'desc')->get();
        return $this->successResponse(data:AdResource::collection($ads));
    }

    public function support_ads()
    {
        $ads = auth()->user()->supportAds()->orderBy('created_at' , 'desc')->without(['user'])->get();
        return $this->successResponse(data:$ads);
    }

    public function userAds(User $user)
    {
        $ads = $user->ads()->withAll()->get();
        return $this->successResponse(data:AdResource::collection($ads));
    }

    public function toggle(string $disable)
    {
        $disable  = 'receive_' . $disable;
        $user = auth()->user();
        $user->$disable = 1 - $user->$disable ;
        $user->save();
        return $this->successResponse(__('changed_successfully'));
    }

    public function resend()
    {
        $user = auth('api')->user();
        $code = generate_verification_code();
        $user->code = $code;
        $user->save();
        $user->refresh();
        $response = OTPController::send($user->phone , $user->code);
        return $this->successResponse(__('sent_successfully') , UserResource::make(auth()->user()));
    }
    public function deleteAccount()
    {
        $user = auth()->user();
        $user->is_deleted = 1;
        $user->save();
        return $this->successResponse(__('deleted_successfully'));
    }

}
