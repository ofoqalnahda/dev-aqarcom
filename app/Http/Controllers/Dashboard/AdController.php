<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index(Request $request)
    {
      //  dd($request->user);
        $ads_d = Ad::withoutGlobalScopes()->with('user')->when(\request()->user_id , function ($query){
            return $query->where('user_id' , \request()->user_id);
        })->when(\request()->type , function ($query){
            return $query->where('main_type' , \request()->type);
        })->when(request()->ad_type_id , function ($query){
            return $query->where('ad_type_id' , request()->ad_type_id);
        });
        $ads_expiry = Ad::withoutGlobalScopes()->with('user')->when(\request()->user_id , function ($query){
            return $query->where('user_id' , \request()->user_id);
        })->when(\request()->type , function ($query){
            return $query->where('main_type' , \request()->type);
        })->when(request()->ad_type_id , function ($query){
            return $query->where('ad_type_id' , request()->ad_type_id);
        });
      $expiry_count = $ads_expiry->where('active',true)->whereHas('platform', function ($q) {
                 $q->whereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.endDate')), '%d/%m/%Y') < CURDATE()");
        })->count();

 
        $ads=$ads_d->latest()->paginate(20);

        return view('dashboard.ads.index' , compact('ads','expiry_count'));
    }
    public function changeStatusExpiry(Request $request)
    {
        

        $ads_d = Ad::with('platform')->whereHas('platform', function ($q) {
                 $q->whereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.endDate')), '%d/%m/%Y') < CURDATE()");
        })->where('active',true)->update([
            'active'=> false
            ]);
        return to_route('dashboard.ads.index')->with('success',__('changed_successfully'));

    }
    public function Expiry(Request $request)
    {
        $ads_d = Ad::withoutGlobalScopes()->where('active',false)->with('user')
        ->when(\request()->user_id , function ($query){
            return $query->where('user_id' , \request()->user_id);
        })->when(\request()->type , function ($query){
            return $query->where('main_type' , \request()->type);
        })->when(request()->ad_type_id , function ($query){
            return $query->where('ad_type_id' , request()->ad_type_id);
        });
        $ads = $ads_d->latest()->paginate(20);
        
         $ads_expiry = Ad::withoutGlobalScopes()->with('user')->when(\request()->user_id , function ($query){
            return $query->where('user_id' , \request()->user_id);
        })->when(\request()->type , function ($query){
            return $query->where('main_type' , \request()->type);
        })->when(request()->ad_type_id , function ($query){
            return $query->where('ad_type_id' , request()->ad_type_id);
        });
      $expiry_count = $ads_expiry->where('active',true)->whereHas('platform', function ($q) {
                 $q->whereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.endDate')), '%d/%m/%Y') < CURDATE()");
        })->count();
        return view('dashboard.ads.index' , compact('ads','expiry_count'));

    }
    
    public function show(Ad $ad)
    {
        $ad->load(['city' , 'user' , 'neighborhood' , 'estateType' , 'estateArea' , 'usageType' , 'adType' ,'platform', 'attachments' , 'options']);
        return view('dashboard.ads.show' , compact('ad'));
    }


    public function destroy(Ad $ad)
    {
        $ad->delete();
        return to_route('dashboard.ads.index')->with('success' , __('deleted_successfully'));
    }
    public function changeStatus(Ad $ad)
    {
        $ad->active = 1 - (int)$ad->active;
        $ad->save();
        return response()->json(['success'=>__('changed_successfully')]);
    }
}
