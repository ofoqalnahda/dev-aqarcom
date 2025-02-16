<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ResponseTrait;
    public function edit()
    {
        $settings = Setting::first();
        return view('dashboard.settings.edit' , compact('settings'));
    }

    public function update(Request $request)
    {
//        dd($request->all()['force_update']);
        $settingsData = $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|digits:10|starts_with:05',
            'whatsapp' => 'nullable|digits:10|starts_with:05',
            'address' => 'nullable|max:255',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'snapchat' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'app_store' => 'nullable|url',
            'huawei_store' => 'nullable|url',
            'google_play' => 'nullable|url',
            'val_url' => 'nullable|url',
            'refresh_ad_limit' => 'nullable|numeric',
            'ar.about_us' => 'nullable|string',
            'en.about_us' => 'nullable|string',
            'ar.terms' => 'nullable|string',
            'en.terms' => 'nullable|string',
            'ar.privacy' => 'nullable|string',
            'en.privacy' => 'nullable|string',
            'en.description' => 'nullable|string',
            'ar.description' => 'nullable|string',
            'en.agreement' => 'nullable|string',
            'ar.agreement' => 'nullable|string',
            'en.ad_conditions' => 'nullable|string',
            'ar.ad_conditions' => 'nullable|string',
            'en.app_commission' => 'nullable|string',
            'ar.app_commission' => 'nullable|string',
            'en.idea_policy' => 'nullable|string',
            'ar.idea_policy' => 'nullable|string',
            'en.our_vision' => 'nullable|string',
            'ar.our_vision' => 'nullable|string',
            'en.our_message' => 'nullable|string',
            'ar.our_message' => 'nullable|string',
            'logo' => 'nullable|mimes:png,jpg,webp,jpeg',
            'default_image' => 'nullable|mimes:png,jpg,webp,jpeg',
            'val_image' => 'nullable|mimes:png,jpg,webp,jpeg',
            "ios_version" => "nullable|string",
            "android_version" => "nullable|string",
            "force_update" => "nullable|boolean",
            "nafath_status" => "nullable|boolean",
            "commission_status" => "nullable|boolean",
            "status_support_services" => "nullable|boolean",
            "default_free_ads" => "nullable|numeric|min:0",
        ]);
//        $settingsData = array_filter($settingsData);

        if ($request->has('logo'))
            $settingsData['logo'] = image_uploader_without_resize($request->logo , 'logo');

        if ($request->has('default_image'))
            $settingsData['default_image'] = image_uploader_without_resize($request->default_image , 'logo');
            
            
        if ($request->has('val_image'))
            $settingsData['val_image'] = image_uploader_without_resize($request->val_image , 'logo');


//        ($setting = Setting::first()) ? $setting->update($settingsData) : Setting::create($settingsData);
        Setting::updateOrCreate(['id'=>1],$settingsData);
        return back()->with(['success'=> __('updated_successfully')]);
    }

    public function version(){
        $setting = Setting::first();
//        dd($setting);
        $data = request()->validate([
            "version" => "required|string|max:255",
            "os" => "required|string|in:android,ios",
        ]);


        $version = [
            "android"=> $setting->android_version,
            "ios"=> $setting->ios_version,
        ];


        $force_update = $setting->force_update && $data['version'] !== $version[$data['os']];

        return $this->successResponse('',[
            'force_update'=>$force_update,
            'version'=>$version[$data['os']],
            'nafath_status'=>(boolean)$setting->nafath_status,
        ]);

    }
     public function deleteAcountStatus()
    {

        $data['status_delete_acount'] = Setting::first()->status_delete_acount == 1 ? true : false;

        return $this->successResponse('' , $data);
    }
}
