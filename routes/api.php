<?php

use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ValLicenseController;
use App\Models\Sponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\FcmNotificationService;
/**************************************[Auth Routes ]*************************************************/
Route::post('login' , [\App\Http\Controllers\Api\AuthController::class , 'login']);
Route::post('register' , [\App\Http\Controllers\Api\AuthController::class , 'register']);

Route::get('get-profile' , [\App\Http\Controllers\Api\AuthController::class , 'getProfile']);
Route::post('update-profile' , [\App\Http\Controllers\Api\AuthController::class , 'updateProfile']);

Route::post('verify' , [\App\Http\Controllers\Api\AuthController::class , 'verify']);
Route::post('forget-password' , [\App\Http\Controllers\Api\AuthController::class , 'forgetPassword']);
Route::post('reset-password' , [\App\Http\Controllers\Api\AuthController::class , 'resetPassword'])->middleware('auth:api');

Route::post("nafath-callback", [\App\Http\Controllers\NafathController::class , 'nafathCallback']);
Route::post("test/nafath-callback", [\App\Http\Controllers\NafathController::class , 'testNafathCallback']);


Route::post("version", [\App\Http\Controllers\Dashboard\SettingController::class , 'version']);


/*************************************[Global Data Routes]********************************************/
Route::get('sliders' , \App\Http\Controllers\Api\SliderController::class);
Route::get('areas' , \App\Http\Controllers\Api\AreaController::class);
Route::get('advertiserOrientation' , \App\Http\Controllers\Api\AdvertiserOrientationController::class);
Route::get('cities' , \App\Http\Controllers\Api\CityController::class);
Route::get('states' , \App\Http\Controllers\Api\StateController::class);
Route::get('neighborhoods' , \App\Http\Controllers\Api\NeighborhoodController::class);
Route::get('ad-types' , \App\Http\Controllers\Api\AdTypeController::class);
Route::get('user/ads/{user}' , [\App\Http\Controllers\Api\UserController::class , 'userAds']);
Route::get('usage-types' , \App\Http\Controllers\Api\UsageTypeController::class);
Route::get('estate-types' , \App\Http\Controllers\Api\EstateTypeController::class);
Route::get('types' , \App\Http\Controllers\Api\TypeController::class);
Route::get('stories/' , [StoryController::class , 'index'] );
Route::get('account-types' , \App\Http\Controllers\Api\AccountTypeController::class);
Route::get('reasons' , \App\Http\Controllers\Api\ReasonController::class);
Route::get('properties/{estateId?}/{typeId?}' , [\App\Http\Controllers\Api\PropertyController::class , 'index']);
Route::get('ads/buy' , [\App\Http\Controllers\Api\AdController::class , 'buyAds']);
Route::get('ads/sell' , [\App\Http\Controllers\Api\AdController::class , 'sellAds']);
Route::get('ads/map' , [\App\Http\Controllers\Api\AdController::class , 'mapIndex']);
Route::get('show-ad/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'show']);
Route::get('user-profile/{user}' , [\App\Http\Controllers\Api\UserController::class , 'show']);
Route::get('services' , [\App\Http\Controllers\Api\ServiceController::class , 'index']);
Route::get('support-services' , [\App\Http\Controllers\Api\SupportServiceController::class , 'index']);
Route::get('support-service-status' , [\App\Http\Controllers\Api\SupportServiceController::class , 'status']);
Route::get('delete-acount-status' , [\App\Http\Controllers\Dashboard\SettingController::class, 'deleteAcountStatus']);

//Route::get('users-support-services' , [\App\Http\Controllers\Api\SupportServiceController::class , 'getUsersSupportServices']);
//Route::get('users-support-services/{user_support_service}' , [\App\Http\Controllers\Api\SupportServiceController::class , 'show']);
Route::get('blogs' , [\App\Http\Controllers\Api\BlogController::class , 'index']);
Route::get('blogs/{blog}' , [\App\Http\Controllers\Api\BlogController::class , 'show']);
Route::get('companies' , [\App\Http\Controllers\Api\UserController::class , 'companies']);
Route::get('bank-accounts' , \App\Http\Controllers\Api\BankAccountController::class );
Route::get('subscriptions' , [\App\Http\Controllers\Api\SubscriptionController::class , 'index']);
Route::post('contact-us' , [\App\Http\Controllers\Api\ContactUsController::class , 'store']);
Route::post('donate' , [\App\Http\Controllers\Api\ContactUsController::class , 'donate']);
Route::post('coupons/check' , \App\Http\Controllers\Api\CouponController::class);
Route::get('ads' , [\App\Http\Controllers\Api\AdController::class , 'index']);
Route::get('support-service-ads' , [\App\Http\Controllers\Api\SupportServiceAdsController::class , 'index']);
Route::get('support-service-ads/{support_service_ad}' , [\App\Http\Controllers\Api\SupportServiceAdsController::class , 'show']);


Route::get('application-data' , \App\Http\Controllers\Api\ApplicationDataController::class);
Route::get('sponsors',fn()=>Sponser::all());

Route::group(['middleware'=>['auth:api' , 'is_active']], function (){
    /************************************************* Ads Requests ****************************************/
    Route::get('resend' , [\App\Http\Controllers\Api\UserController::class , 'resend']);
    Route::get('logout' , [\App\Http\Controllers\Api\AuthController::class , 'logout']);
    Route::get('delete-acount' , [\App\Http\Controllers\Api\AuthController::class , 'deleteAcount']);


    // ads license
    Route::post('check-ads-license' ,[\App\Http\Controllers\Api\AdController::class , 'checkAdsLicense']);
    Route::post('store-ad-sell' , [\App\Http\Controllers\Api\AdController::class , 'storeSell']);
    
    Route::post('store-ad' , [\App\Http\Controllers\Api\AdController::class , 'store']);

    //Nafath
    Route::post("nafath-request", [\App\Http\Controllers\NafathController::class , 'send_request']);
    Route::get("nafath-status", [\App\Http\Controllers\NafathController::class , 'nafath_status']);


    //stories
    Route::get('stories/{ad}' , [StoryController::class , 'show'] );
    Route::get('stories/{ad}/toggle-like' , [StoryController::class , 'toggleLike'] );

    // val license
    Route::post('val-license' ,[ValLicenseController::class , 'store'])->middleware('validate-nafath-verification');

    Route::get('favourite-ads',[\App\Http\Controllers\Api\FavouriteController::class , 'index']);
    Route::get('add-to-favourite/{adId}',[\App\Http\Controllers\Api\FavouriteController::class , 'store']);
    Route::get('remove-from-favourite/{adId}',[\App\Http\Controllers\Api\FavouriteController::class , 'destroy']);
    Route::get('show-update-sell-ad/{adId}' , [\App\Http\Controllers\Api\AdController::class , 'showForUpdate']);
    Route::post('update-ad/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'update']);
    Route::get('delete-ad/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'destroy']);
    Route::get('make-ad-special/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'makeAdSpecial']);
    Route::get('republish/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'rePublish']);
    Route::get('ads/delete-image' , [\App\Http\Controllers\Api\AdController::class , 'deleteImage']);
    Route::get('ads/refresh/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'refresh']);

    Route::get('report-reasons' , \App\Http\Controllers\Api\ReportReasonController::class);
    Route::post('report-ad/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'report']);
    Route::post('cellation-ad/{adId}' , [\App\Http\Controllers\Api\AdController::class , 'Adcancellation']);
    Route::post('update-sell-ad/{ad}' , [\App\Http\Controllers\Api\AdController::class , 'updateSell']);
    Route::post('change-password' , [\App\Http\Controllers\Api\UserController::class , 'changePassword']);
    Route::get('delete-account' , [\App\Http\Controllers\Api\UserController::class , 'deleteAccount']);



    /************************************************** User Requests***************************************/
    Route::post('user/update' , [\App\Http\Controllers\Api\UserController::class , 'update']);
    Route::post('user-verify' , [\App\Http\Controllers\Api\UserController::class , 'verifyUser']);
    Route::get('user-followers' , [\App\Http\Controllers\Api\FollowerController::class , 'index']);
    Route::get('user-follow/{user}' , [\App\Http\Controllers\Api\FollowerController::class , 'follow']);
    Route::get('user-unfollow/{user}' , [\App\Http\Controllers\Api\FollowerController::class , 'unFollow']);
    Route::get('user/ads' , [\App\Http\Controllers\Api\UserController::class , 'ads']);
    Route::get('user/support-ads' , [\App\Http\Controllers\Api\UserController::class , 'support_ads']);


    Route::get('user-blocks' , [\App\Http\Controllers\Api\BlockUserController::class , 'index']);
    Route::get('user-block/{user}' , [\App\Http\Controllers\Api\BlockUserController::class , 'store']);
    Route::get('user-unblock/{user}' , [\App\Http\Controllers\Api\BlockUserController::class , 'destroy']);

    Route::post('subscription/store' , [\App\Http\Controllers\Api\SubscriptionController::class , 'store']);
    Route::post('subscription/store-free' , [\App\Http\Controllers\Api\SubscriptionController::class , 'storeFree']);
    Route::post('subscription/update' , [\App\Http\Controllers\Api\SubscriptionController::class , 'update']);
    Route::post('subscription/services/update' , [\App\Http\Controllers\Api\SubscriptionController::class , 'updateServices']);
    Route::post('subscription/services/delete' , [\App\Http\Controllers\Api\SubscriptionController::class , 'deleteServices']);

    Route::get('subscription/delete-image' , [\App\Http\Controllers\Api\SubscriptionController::class , 'deleteImage']);



    /* Bank Calculations */
    Route::post("bank-calculations" , [\App\Http\Controllers\BankCalcController::class , 'store']);
    Route::get("bank-calculations" , [\App\Http\Controllers\BankCalcController::class , 'index']);
    Route::get("bank-calculations/jobs" , [\App\Http\Controllers\BankCalcController::class , 'jobs']);


    /* User Services */

//    Route::apiResource('user-support-services' , \App\Http\Controllers\Api\UserSupportServiceController::class);
    Route::get('user-support-services' , [\App\Http\Controllers\Api\UserSupportServiceController::class , 'index']);
    Route::post('user-support-services' , [\App\Http\Controllers\Api\UserSupportServiceController::class , 'store']);
    Route::post('user-support-services/{user_support_service}' , [\App\Http\Controllers\Api\UserSupportServiceController::class , 'update']);
    Route::delete('user-support-services/{user_support_service}' , [\App\Http\Controllers\Api\UserSupportServiceController::class , 'destroy']);
//    Route::get('user-services/{user_service}' , [\App\Http\Controllers\Api\UserHelperServiceController::class , 'show']);
    /* User Service Ads */
    Route::post('support-service-ads' , [\App\Http\Controllers\Api\SupportServiceAdsController::class , 'store']);
    Route::post('support-service-ads/{support_service_ad}' , [\App\Http\Controllers\Api\SupportServiceAdsController::class , 'update']);
    Route::delete('support-service-ads/{support_service_ad}' , [\App\Http\Controllers\Api\SupportServiceAdsController::class , 'destroy']);

    /************************************  Chat Routes ************************************************************/
    Route::get('chats/index' , [\App\Http\Controllers\Api\ChatController::class , 'index']);
    Route::get('chats/{chat}' , [\App\Http\Controllers\Api\ChatController::class , 'show']);
    Route::post('chats/send-message' , [\App\Http\Controllers\Api\ChatController::class , 'store']);


    Route::get('toggle/{disable}' , [\App\Http\Controllers\Api\UserController::class , 'toggle']);
});

