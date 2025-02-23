<?php

use App\Http\Controllers\Dashboard\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\Dashboard\AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [\App\Http\Controllers\Dashboard\AuthController::class, 'login'])->name('login');

Route::group(['middleware' =>[ 'auth:admin' ,'check-permission']], function () {
    Route::get('/logout', [\App\Http\Controllers\Dashboard\AuthController::class, 'logout'])->name('logout');

    Route::get('/', [\App\Http\Controllers\Dashboard\HomeController::class, 'index'])->name('home');


    Route::resource('coupons', \App\Http\Controllers\Dashboard\CouponController::class)->except(['show']);
    Route::post('coupons/toggle/{coupon}', [\App\Http\Controllers\Dashboard\CouponController::class, 'toggle'])->name('coupons.toggle');

    Route::get("bank-calculations", [\App\Http\Controllers\BankCalcController::class, 'index'])->name('bankCalcs.index');
    Route::get("bank-calculations/{bankCalc}", [\App\Http\Controllers\BankCalcController::class, 'show'])->name('bankCalcs.show');
    Route::get("bank-calculations/{bankCalc}/edit", [\App\Http\Controllers\BankCalcController::class, 'edit'])->name('bankCalcs.edit');
    Route::put("bank-calculations/{bankCalc}", [\App\Http\Controllers\BankCalcController::class, 'update'])->name('bankCalcs.update');
    Route::post("bank-calculations/{bankCalc}", [\App\Http\Controllers\BankCalcController::class, 'resend'])->name('bankCalcs.resend');
    // Rolesss
    Route::resource('roles', RoleController::class)->except(['show']);

    Route::resource('admins', \App\Http\Controllers\Dashboard\AdminController::class)->except(['show']);
    Route::resource('areas', \App\Http\Controllers\Dashboard\AreaController::class)->except(['show']);
    Route::resource('cities', \App\Http\Controllers\Dashboard\CityController::class)->except(['show']);
    Route::resource('states', \App\Http\Controllers\Dashboard\StateController::class)->except(['show']);
    Route::resource('neighborhoods', \App\Http\Controllers\Dashboard\NeighborhoodController::class)->except(['show']);
    Route::resource('adTypes', \App\Http\Controllers\Dashboard\AdTypeController::class)->except(['show']);
    Route::resource('estateTypes', \App\Http\Controllers\Dashboard\EstateTypeController::class)->except(['show']);
    Route::resource('usageTypes', \App\Http\Controllers\Dashboard\UsageTypeController::class)->except(['show']);
    Route::resource('advertiserOrientations', \App\Http\Controllers\Dashboard\AdvertiserOrientationController::class)->except(['show']);
    Route::resource('accountTypes', \App\Http\Controllers\Dashboard\AccountTypeController::class)->except(['show']);
    Route::resource('blogs', \App\Http\Controllers\Dashboard\BlogController::class)->except(['show']);
    Route::resource('services', \App\Http\Controllers\Dashboard\ServiceController::class)->except(['show']);
    Route::resource('users', \App\Http\Controllers\Dashboard\UserController::class)->only(['index', 'destroy', 'show']);
    Route::resource('sliders', \App\Http\Controllers\Dashboard\SliderController::class)->except(['show', 'edit', 'update']);
    Route::resource('ads', \App\Http\Controllers\Dashboard\AdController::class)->only(['index', 'show', 'destroy']);
    Route::get('ads-change-status-expiry', [\App\Http\Controllers\Dashboard\AdController::class,'changeStatusExpiry'])->name('ads.changeStatusExpiry');
    Route::get('ads-expiry', [\App\Http\Controllers\Dashboard\AdController::class,'Expiry'])->name('ads.Expiry');
    Route::resource('supportServiceAds', \App\Http\Controllers\Dashboard\SupportServiceAdsController::class)->only(['index', 'show', 'destroy']);
    Route::resource('reportReasons', \App\Http\Controllers\Dashboard\ReportReasonController::class)->except(['show']);
    Route::resource('bankAccounts', \App\Http\Controllers\Dashboard\BankAccountController::class);
    Route::resource('adReports', \App\Http\Controllers\Dashboard\AdReportController::class)->only(['destroy', 'index']);
    Route::get('subscriptions/changeStatus/{subscription}', [\App\Http\Controllers\Dashboard\SubscriptionController::class, 'changeStatus'])->name('subscriptions.changeStatus');
    Route::resource('subscriptions', \App\Http\Controllers\Dashboard\SubscriptionController::class)->except(['show']);
    Route::resource('properties', \App\Http\Controllers\Dashboard\PropertyController::class)->except(['show']);
    Route::get('marketers/get-code',  [\App\Http\Controllers\Dashboard\MarketerController::class, 'getCode'])->name('marketers.getCode');
    Route::get('marketers/get-data',  [\App\Http\Controllers\Dashboard\MarketerController::class, 'getData'])->name('marketers.getData');

    Route::resource('marketers', \App\Http\Controllers\Dashboard\MarketerController::class);
    Route::get('marketers/draws/{marketer}', [\App\Http\Controllers\Dashboard\MarketerController::class, 'draws'])->name('marketers.draws');
    Route::get('marketers/clear-balance/{marketer}', [\App\Http\Controllers\Dashboard\MarketerController::class, 'clearBalance'])->name('marketers.clear');
    Route::get('marketers/send-code/{marketer}', [\App\Http\Controllers\Dashboard\MarketerController::class, 'sendCode'])->name('marketers.sendCode');

    Route::resource('supportServices', \App\Http\Controllers\Dashboard\SupportServicesController::class)->except(['show'])->parameter('supportServices', 'service');
    Route::resource('prePurchaseServices', \App\Http\Controllers\Dashboard\PrePurchaseServicesController::class)->except(['show'])->parameter('prePurchaseServices', 'service');;
    Route::resource('postPurchaseServices', \App\Http\Controllers\Dashboard\PostPurchaseServicesController::class)->except(['show'])->parameter('postPurchaseServices', 'service');;
    Route::resource('estateDeveloperServices', \App\Http\Controllers\Dashboard\EstateDeveloperServicesController::class)->except(['show'])->parameter('estateDeveloperServices', 'service');;
    Route::resource('afterSellServices', \App\Http\Controllers\Dashboard\AfterSellServicesController::class)->except(['show'])->parameter('afterSellServices', 'service');;
    Route::resource('sponsors', \App\Http\Controllers\Dashboard\SponsorsController::class)->except(['show', 'edit', 'update']);
    Route::resource('features', \App\Http\Controllers\Dashboard\FeatureController::class)->except(['show']);

    Route::get('users/changeStatus/{user}', [\App\Http\Controllers\Dashboard\UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::post('users/changeBalance/{user}', [\App\Http\Controllers\Dashboard\UserController::class, 'changeBalance'])->name('users.changeBalance');
    Route::get('users/delete-subscription/{user}', [\App\Http\Controllers\Dashboard\UserController::class, 'deleteSubscription'])->name('users.deleteSubscription');

    Route::get('ads/changeStatus/{ad}', [\App\Http\Controllers\Dashboard\AdController::class, 'changeStatus'])->name('ads.changeStatus');
    Route::get('supportServiceAds/toggle/{supportServiceAd}', [\App\Http\Controllers\Dashboard\SupportServiceAdsController::class, 'toggle'])->name('supportServiceAds.toggle');

    Route::get('contactMessages', [\App\Http\Controllers\Dashboard\ContactController::class, 'index'])->name('contact.index');
    Route::get('todaySubscriptions', [\App\Http\Controllers\Dashboard\SubscriptionRequestController::class, 'todaySubscriptions'])->name('todaySubscriptions');

    Route::get('subscriptionRequests', [\App\Http\Controllers\Dashboard\SubscriptionRequestController::class, 'index'])->name('subscriptionRequests.index');

    Route::get('authenticationRequests', [\App\Http\Controllers\Dashboard\AuthenticationRequestController::class, 'index'])->name('authenticationRequests.index');

    Route::get('authenticationRequests/accept/{user}', [\App\Http\Controllers\Dashboard\AuthenticationRequestController::class, 'accept'])->name('authenticationRequests.accept');

    Route::get('authenticationRequests/reject/{user}', [\App\Http\Controllers\Dashboard\AuthenticationRequestController::class, 'reject'])->name('authenticationRequests.reject');

    Route::get('subscriptionRequests/accept/{subscriptionRequest}', [\App\Http\Controllers\Dashboard\SubscriptionRequestController::class, 'accept'])->name('subscriptionRequests.accept');
    Route::get('subscriptionRequests/reject/{subscriptionRequest}', [\App\Http\Controllers\Dashboard\SubscriptionRequestController::class, 'reject'])->name('subscriptionRequests.reject');

    Route::get('states/update-location/{state}', [\App\Http\Controllers\Dashboard\StateController::class, 'updateLocationForm'])->name('states.updateLocationForm');
    Route::post('states/update-location/{state}', [\App\Http\Controllers\Dashboard\StateController::class, 'updateLocation'])->name('states.updateLocation');

    Route::get('sections', [\App\Http\Controllers\Dashboard\SectionController::class, 'edit'])->name('sections.edit');
    Route::post('sections/{section}', [\App\Http\Controllers\Dashboard\SectionController::class, 'update'])->name('sections.update')->missing(function () {
        app()->setLocale(session('locale') ?? 'ar');
        return back()->withErrors(__('select_section'));
    });

    Route::get('notifications', [\App\Http\Controllers\Dashboard\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/send', [\App\Http\Controllers\Dashboard\NotificationController::class, 'sendForm'])->name('notifications.sendForm');
    Route::POST('notifications/send', [\App\Http\Controllers\Dashboard\NotificationController::class, 'send'])->name('notifications.send');
    Route::get('notifications/show/{notification_id}', [\App\Http\Controllers\Dashboard\NotificationController::class, 'show'])->name('notifications.show');

    Route::get('offers/create' , [\App\Http\Controllers\Dashboard\OffersController::class , 'create'])->name('offers.create');
    Route::get('offers/{chat}' , [\App\Http\Controllers\Dashboard\OffersController::class , 'show'])->name('offers.show');
    Route::post('offers/{chat}' , [\App\Http\Controllers\Dashboard\OffersController::class , 'update'])->name('offers.update');
    Route::get('offers' , [\App\Http\Controllers\Dashboard\OffersController::class , 'index'])->name('offers.index');
    Route::POST('offers' , [\App\Http\Controllers\Dashboard\OffersController::class , 'store'])->name('offers.store');
    Route::get('contactMessages', [\App\Http\Controllers\Dashboard\ContactController::class, 'index'])->name('contact.index');
    Route::resource('sliders', \App\Http\Controllers\Dashboard\SliderController::class)->except(['show']);

    Route::get('settings', [\App\Http\Controllers\Dashboard\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings/update', [\App\Http\Controllers\Dashboard\SettingController::class, 'update'])->name('settings.update');

});

