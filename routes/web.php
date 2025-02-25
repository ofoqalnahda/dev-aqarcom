<?php

use App\Models\Section;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('optimize', function () {
    Artisan::call('optimize:clear');
    return 'Cleared';
});

Route::get('secret-migrate', function () {
//    dd(get_file(''));
    Artisan::call('migrate');
    return Artisan::output();
});

Route::post("nafath-callback", [\App\Http\Controllers\NafathController::class , 'nafathCallback']);
Route::post("test/nafath-callback", [\App\Http\Controllers\NafathController::class , 'testNafathCallback']);

Route::get('permission-seeder', function () {
    Artisan::call('db:seed', ['--class' => 'RolePermissionSeeder']);
    return Artisan::output();
});
Route::get('join-us-now', function () {
    $setting=Setting::first();
    $userAgent = strtolower(request()->header('User-Agent'));

    if (str_contains($userAgent, 'android')) {
        return redirect()->away($setting->google_play);
    } elseif (str_contains($userAgent, 'iphone') || str_contains($userAgent, 'ipad')) {
        return redirect()->away($setting->app_store);
    } elseif (str_contains($userAgent, 'huawei') || str_contains($userAgent, 'honor')) {
        return redirect()->away($setting->huawei_store);

    } else {
        return redirect()->route('home', ['#getApp']);
    }
});

Route::get('payment/create/{amount}', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
Route::get('payment/store/{process}/{user?}/{subscription?}', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store');

Route::get('change-locale/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('changeLocale');


/* old */

Route::get('/', function () {
    $about_app = Section::with('images')->where('section_name', 'about_app')->first();
    $support_services = Section::with('images')->where('section_name', 'support_services')->first();
    $who_we_are = Section::with('images')->where('section_name', 'who_we_are')->first();
    $our_vision = Section::with('images')->where('section_name', 'our_vision')->first();
    $our_message = Section::with('images')->where('section_name', 'our_message')->first();
    $app_features = Section::with('images')->where('section_name', 'app_features')->first();
    $pre_purchase_services = Section::with('images')->where('section_name', 'pre_purchase_services')->first();
    $post_purchase_services = Section::with('images')->where('section_name', 'post_purchase_services')->first();
    $after_sell_services = Section::with('images')->where('section_name', 'after_sell_services')->first();
    $app_images = Section::with('images')->where('section_name', 'app_images')->first();

    $features = \App\Models\Feature::all();
    $services = \App\Models\Service::all();
    $sponsors = \App\Models\Sponser::all();
    $supportServices = \App\Models\SupportService::all();
    $afterSellServices = \App\Models\AfterSellService::all();
    $prePurchaseServices = \App\Models\PrePurchaseService::all();
    $postPurchaseServices = \App\Models\PostPurchaseService::all();
    $estateDevelopersServices = \App\Models\EstateDeveloperService::all();

    $setting = Setting::first();
    return view('home-old', compact([
        'about_app', 'our_message', 'our_vision', 'app_features', 'who_we_are', 'pre_purchase_services', 'sponsors'
        , 'post_purchase_services', 'after_sell_services', 'app_images', 'support_services', 'setting',
        'features', 'supportServices', 'afterSellServices', 'prePurchaseServices', 'postPurchaseServices', 'estateDevelopersServices', 'services',
    ]));
})->name('home');

Route::get('privacy', function () {
    $privacy = \App\Models\Setting::first();
    return view('privacy', compact('privacy'));
})->name('privacy');

/* end-old */

Route::post("/deleteacount",function(){
    $data = request()->validate([
        'phone' => 'required|exists:users,phone',
        'password' => 'required',
    ]);
    $user = \App\Models\User::where('phone',$data['phone'])->first();
    if(Hash::check($data['password'],$user->password)){
        $user->password = bcrypt('1234');
        $user->save();
        return redirect()->back()->with('success',__('account_deleted_successfully'));
    }
    return redirect()->back()->with('error',__('password_is_wrong'));
})->name('delete-account');

Route::get("/deleteacount",function(){
    $about_app = Section::with('images')->where('section_name', 'about_app')->first();
    $support_services = Section::with('images')->where('section_name', 'support_services')->first();
    $who_we_are = Section::with('images')->where('section_name', 'who_we_are')->first();
    $our_vision = Section::with('images')->where('section_name', 'our_vision')->first();
    $our_message = Section::with('images')->where('section_name', 'our_message')->first();
    $app_features = Section::with('images')->where('section_name', 'app_features')->first();
    $pre_purchase_services = Section::with('images')->where('section_name', 'pre_purchase_services')->first();
    $post_purchase_services = Section::with('images')->where('section_name', 'post_purchase_services')->first();
    $after_sell_services = Section::with('images')->where('section_name', 'after_sell_services')->first();
    $app_images = Section::with('images')->where('section_name', 'app_images')->first();

    $features = \App\Models\Feature::all();
    $services = \App\Models\Service::all();
    $sponsors = \App\Models\Sponser::all();
    $supportServices = \App\Models\SupportService::all();
    $afterSellServices = \App\Models\AfterSellService::all();
    $prePurchaseServices = \App\Models\PrePurchaseService::all();
    $postPurchaseServices = \App\Models\PostPurchaseService::all();
    $estateDevelopersServices = \App\Models\EstateDeveloperService::all();

    $setting = Setting::first();
    return view('delete-account', compact([
        'about_app', 'our_message', 'our_vision', 'app_features', 'who_we_are', 'pre_purchase_services', 'sponsors'
        , 'post_purchase_services', 'after_sell_services', 'app_images', 'support_services', 'setting',
        'features', 'supportServices', 'afterSellServices', 'prePurchaseServices', 'postPurchaseServices', 'estateDevelopersServices', 'services',
    ]));

});


// Route::get('{any}', function () {
//     return view('home');
// })->where('any', '.*')->name('home');
