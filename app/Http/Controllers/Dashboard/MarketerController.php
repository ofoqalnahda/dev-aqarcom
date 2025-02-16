<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Marketer;
use App\Models\Setting;
use App\Models\UserSubscription;
use App\Http\Requests\Dashboard\MarketerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\OTPController;
use App\Models\Subscription;

class MarketerController extends Controller
{
    public function index(Request $request)
    {
        $marketers = Marketer::get();

        return view('dashboard.marketers.index' , compact('marketers'));
    }


    public function create()
    {
        $subscriptions = Subscription::get();

        return view('dashboard.marketers.create' , compact('subscriptions'));
    }

    public function store(MarketerRequest $request)
    {
       
        $marketerData = $request->safe()->except(['image','subscription_commission_percentage','subscription_discount_percentage']);
        if($request->image){
                    $marketerData['image'] = image_uploader_with_resize($request->image,'marketers',300 , 300);
        }
        $marketer = Marketer::create($marketerData);
        if($request->subscription_commission_percentage){
            $data=[];
            foreach($request->subscription_commission_percentage as $id => $subscription){
                 $data[$id]=['commission_percentage'=>$subscription,
                'discount_percentage'=>$request->subscription_discount_percentage[$id]];
            } 
            $marketer->subscriptions()->sync($data);
        }
            
        return to_route('dashboard.marketers.index')->with(['success'=>'تم الإضافة بنجاح !']);
    }

    public function edit(Marketer $marketer)
    {
        $subscriptions = Subscription::get();
                $oldSubscriptions=[];
        foreach($marketer->subscriptions as $subscription){
              $oldSubscriptions[$subscription->id] = [
                  'commission_percentage'=>$subscription->pivot->commission_percentage,
                  'discount_percentage'=>$subscription->pivot->discount_percentage,
                  ];
        }
        
        return view('dashboard.marketers.edit' , compact('marketer' , 'subscriptions','oldSubscriptions'));
    }


    public function update(MarketerRequest $request, Marketer $marketer)
    {
        $marketerData = $request->safe()->except(['image','subscription_commission_percentage','subscription_discount_percentage']);

        if($request->image)
            $marketerData['image'] = image_uploader_with_resize($request->image,'marketers',300 , 300);

        $marketer->update($marketerData);
        
         
           if($request->subscription_commission_percentage){
               $data=[];
            foreach($request->subscription_commission_percentage as $id => $subscription){
                $data[$id]=['commission_percentage'=>$subscription,
                'discount_percentage'=>$request->subscription_discount_percentage[$id]];
            } 
            $marketer->subscriptions()->sync($data);
        }

        return to_route('dashboard.marketers.index')->with(['success'=>'تم التعديل بنجاح !']);
    }

    public function draws(Marketer $marketer){
        $draws = $marketer->draws;
        $subscriptionRequests =$marketer->transactions()->wherehas('user')->get();
        return view('dashboard.marketers.draws' , compact('draws' , 'subscriptionRequests'));
    }

    public function clearBalance(Marketer $marketer){
        if($marketer->balance > 0){
            $marketer->draws()->create([
                'balance' => $marketer->balance,
            ]);
            $marketer->balance = 0;
            $marketer->save();
        }

        return to_route('dashboard.marketers.index')->with(['success'=>'تمت التصفية بنجاح']);
    }

    public function show(Marketer $marketer){

        return view('dashboard.marketers.show' , compact('marketer'));
    }


    public function sendCode(Marketer $marketer){
        $new_code = rand(1000 , 9999);
        $marketer->delete_code = $new_code;
        $marketer->save();

        $phone = Setting::first()?->phone;
        OTPController::send($phone ?? '0543442066' , $new_code);
        return response()->json();
    }

    public function destroy(Marketer $marketer)
    {
        if(request()->code == null || (request()->code != $marketer->delete_code))
            return response()->json([] , 422);

        $marketer->delete();
        return response()->json();
    }
}
