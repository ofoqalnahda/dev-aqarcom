<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Marketer;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Services\FcmNotificationService;
use App\Traits\MarketerTransaction;

class SubscriptionRequestController extends Controller
{
    use MarketerTransaction;
    public function index()
    {
        $subscriptionRequests = UserSubscription::where('is_active' , 0)->with(['user' , 'subscription' , 'payment'])->get();
        return view('dashboard.subscriptionRequests.index' , compact('subscriptionRequests'));

    }

    public function accept(UserSubscription $subscriptionRequest)
    {
        $subscriptionRequest->is_active = 1;
        $subscriptionRequest->save();

        if($subscriptionRequest->coupon){
            $marketer  = Marketer::where('code' , $subscriptionRequest->coupon)->first();
            if($marketer){
                $marketer->balance += $subscriptionRequest->price * ($marketer->commission_percentage / 100);
                $marketer->save();
                $this->storeTransaction($marketer , $subscriptionRequest);
            }
        }

        $messageData = [
            'title' => 'طلب اشتراك',
            'message'  => 'تم قبول طلب الاشتراك الخاص بك',
        ];
        FcmNotificationService::sendGroupNotification([$subscriptionRequest->user->device_token] ,$messageData);

        return to_route('dashboard.subscriptionRequests.index')->with(['success'=>__('updated_successfully')]);
    }

    public function reject(UserSubscription $subscriptionRequest)
    {
        $subscriptionRequest->delete();

        $messageData = [
            'title' => 'طلب اشتراك',
            'message'  => 'تم رفض طلب الاشتراك الخاص بك من قبل الادارة',
        ];
        FcmNotificationService::sendGroupNotification([$subscriptionRequest->user->device_token] ,$messageData);

        return to_route('dashboard.subscriptionRequests.index')->with(['success'=>__('deleted_successfully')]);
    }




    public function todaySubscriptions(){
        $subscriptions=UserSubscription::where('is_active',1);
        if(request()->expiringSoon && is_numeric(request()->expiringSoon) )
        {
            $endDate = now()->addDays(request()->expiringSoon);
            $subscriptions = $subscriptions->where('end_date', '<=', $endDate)->where('end_date', '>=', now());
        }

        if(isset(request()->premium) && request()->premium == 1)
        {
            $subscriptions =$subscriptions->whereHas('subscription' , function($q){
                $q->where('premium' , 1);
            });
        }
        elseif(isset(request()->premium) && request()->premium == 0)
        {
            $subscriptions =$subscriptions->whereHas('subscription' , function($q){
                $q->where('premium' , 0);
            });
        }

        $subscriptions = $subscriptions->get();
//        dd($subscriptions[0]);
        return view('dashboard.todaySubscriptions.index' , compact('subscriptions'));
    }













}
