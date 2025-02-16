<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FcmNotificationService;

class AuthenticationRequestController extends Controller
{
    public function index()
    {
        $users = User::where('pending_authentication' , 1)->with('payment')->latest()->get();
        return view('dashboard.authenticationRequests.index' , compact('users'));
    }

    public function accept(User $user)
    {
        abort_if(!$user->pending_authentication , 403);

        $user->is_authentic = 1;
        $user->pending_authentication = 0;
        $user->save();
        
        $messageData = [
            'title' => 'طلب توثيق',
            'message'  => 'تم قبول طلب توثيق الحساب الخاص بك',
        ];
        
        FcmNotificationService::sendGroupNotification([$user->device_token] ,$messageData);
        
        return to_route('dashboard.authenticationRequests.index')->with(['success'=>__('verified_successfully')]);
    }


    public function reject(User $user)
    {
        abort_if(!$user->pending_authentication , 403);

        $user->pending_authentication = 0;
        $user->save();
        
        $messageData = [
            'title' => 'طلب توثيق',
            'message'  => 'تم رفض طلب توثيق الحساب الخاص بك من قبل الادارة',
        ];
        FcmNotificationService::sendGroupNotification([$user->device_token] ,$messageData);
        
        return to_route('dashboard.authenticationRequests.index')->with(['success'=>__('deleted_successfully')]);
    }
}
