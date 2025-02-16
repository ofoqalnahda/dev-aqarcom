<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\OTPController;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\This;

class AuthController extends Controller
{
    use ResponseTrait;
    public function register(RegisterRequest $request)
    {
        $userData = $request->safe()->except(['password' , 'image' ,'whatsapp']);
        $userData['whatsapp'] = $request->whatsapp ?? $request->phone;
        $userData['password'] = bcrypt($request->password);
        $userData['code'] = generate_verification_code();
        $userData['free_ads'] = Setting::first()->default_free_ads??0;
        $userData['device_token'] = $request->device_token;
//        dd($userData,Setting::first());
        if($request->image)
            $userData['image'] = image_uploader_without_resize($request->image , 'users');

        $user = User::create($userData);

        OTPController::send($user->phone , $user->code);
        $user->token = $user->createToken('token')->plainTextToken;

        return $this->successResponse(__('register_success') , UserResource::make($user));
    }


    public function login(LoginRequest $request)
    {
        $user = User::where('phone' ,$request->phone)->first();
        if($user && Hash::check($request->password , $user->password) && !$user->is_deleted){
            if(!$user->is_active){
                return $this->failedResponse(__('in_active'));
            }

            if($request->device_token)
                $user->update(['device_token'=>$request->device_token]);

            $user->update(['last_login' => Carbon::now()]);

            $message = $user->is_verified ? __('login_success') : __('not_verified');
            $user->token = $user->createToken('token')->plainTextToken;
            return $this->successResponse($message , UserResource::make($user));
        }

        return $this->failedResponse(__('wrong_credentials'));
    }


    public function verify(Request $request){
        $data = $request->validate([
            'code'=>['required' , 'digits:4'],
            'phone'=>['sometimes' , 'exists:users,phone']
        ]);
        $code = $data['code'];
        if($request->has('phone')){
            $user = User::where([
                'phone' => $request->phone,
                ])->first();
        }
        else{
            $this->middleware('auth:api');
            $user = auth('api')->user();
        }


        if(!$user || $user->code != $code)
            return $this->failedResponse(__('wrong_code'));

        $user->is_verified = 1;
        $user->save();
        $user->token = $user->createToken('token')->plainTextToken;

        return $this->successResponse(__('code_verified') , UserResource::make($user));
    }


    public function forgetPassword(Request $request)
    {
        $phone = $request->validate([
            'phone' => ['required' , 'exists:users,phone']
        ])['phone'];
        $user = User::where('phone' , $phone)->first();
        $code = generate_verification_code();
        $user->code = $code;
        $user->save();
        $user->refresh();
        OTPController::send($user->phone , $user->code);
        $user->token = $user->createToken('token')->plainTextToken;

        return $this->successResponse(__('code_sent') );
        return $this->successResponse('' , UserResource::make($user));
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        $password = $request->validated()['password'];
        $user = auth('api')->user();
        $user->password = bcrypt($password);
        $user->save();
        $user->token = $user->createToken('token')->plainTextToken;
        return $this->successResponse(__('reset_successfully') , UserResource::make($user));
    }

    public function logout()
    {
        $user = auth('api')->user();
        $user->device_token = null;
        $user->save();
        return $this->successResponse(__('loggedOut_successfully'));
    }
    
    public function deleteAcount()
    {
        $user = auth('api')->user();
        $user->delete();
        return $this->successResponse(__('delete_successfully'));
    }
    

}
