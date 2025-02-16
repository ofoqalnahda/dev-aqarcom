<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FcmNotificationService;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search , function ($query) use ($request){
            return $query->where('phone' , 'like' , '%' .$request->search . '%')->orWhere('name' , 'like' , '%' .$request->search . '%');
        })->when(\request()->nafath_verified , function ($query){
            return $query->where('is_nafath_verified' , \request()->nafath_verified);
        })->withCount('ads')->latest()->paginate(20);
        return view('dashboard.users.index' , compact('users'));
    }

    public function show(User $user)
    {
        $subscription = $user->subscription()->wherePivot('is_active' , 1)->first();
        return view('dashboard.users.show' , compact('user' , 'subscription'));
    }


    public function destroy(User $user)
    {
        $user->delete();
        return to_route('dashboard.users.index')->with('success' , __('deleted_successfully'));
    }

    public function changeStatus(User $user)
    {
        $user->is_active = 1 - (int)$user->is_active;
        $user->save();
        return response()->json(['success'=>__('changed_successfully')]);
    }


    public function deleteSubscription(User $user)
    {
        $user->subscription()->wherePivot('is_active' , 1)->detach();
        $user->services()->detach();

        $messageData = [
            'title' => 'حساب الشركة',
            'message'  => 'تم حذف حساب الشركة الخاص بك , الرجاء التواصل مع الادارة',
        ];
        FcmNotificationService::sendGroupNotification([$user->device_token] ,$messageData);
        return to_route('dashboard.users.show' , $user->id)->with('success' , __('deleted_successfully'));
    }

    public function changeBalance(Request $request , User $user)
    {
        $request->validate([
            'balance' => ['required' , 'numeric' , 'min:0']
        ]);
        $user->free_ads = $request->balance;
        $user->save();
        return to_route('dashboard.users.show' , $user->id)->with('success' , __('changed_successfully'));
    }
}
