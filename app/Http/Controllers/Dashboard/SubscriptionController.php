<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::with(['translation'])->get();

        return view('dashboard.subscriptions.index' , compact('subscriptions'));
    }


    public function create()
    {
        return view('dashboard.subscriptions.create');
    }

    public function store(SubscriptionRequest $request)
    {
        $subscriptionData = $request->validated();

        $subscriptionData['premium'] = $request->premium ? 1 : 0;
        $subscriptionData['location'] =$request->location ? 1 : 0 ;
        $subscriptionData['features'] = $this->formatFeatures($request->features);
        $subscriptionData['status'] =1;

        Subscription::create($subscriptionData);
        return to_route('dashboard.subscriptions.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Subscription $subscription)
    {
        return view('dashboard.subscriptions.edit' , compact('subscription'));
    }


    public function update(SubscriptionRequest $request, Subscription $subscription)
    {

        $subscriptionData = $request->validated();
        $subscriptionData['premium'] = $request->premium ? 1 : 0;
        $subscriptionData['location'] =$request->location ? 1 : 0 ;
        $subscriptionData['features'] = $this->formatFeatures($request->features);

        $subscription->update($subscriptionData);

        return to_route('dashboard.subscriptions.index')->with(['success'=>__('updated_successfully')]);
    }
    public function changeStatus( $subscription_id)
    {
        $subscriptionData =Subscription::where('id',$subscription_id)->first();
        $subscriptionData->status = 1 - (int)$subscriptionData->status;
        $subscriptionData->save();
        return response()->json(['success'=>__('changed_successfully')]);
    }   
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return to_route('dashboard.subscriptions.index')->with(['success'=>__('deleted_successfully')]);
    }

    public function formatFeatures(array $features)
    {
        $features = array_map(function($x){
            return array_map(fn($i) => $i ?? '' , $x);
        }, $features);

        return json_encode($features);
    }
}
