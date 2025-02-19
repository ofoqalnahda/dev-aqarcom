<?php

use App\Http\Controllers\Api\AccountTypeController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\AdTypeController;
use App\Http\Controllers\Api\AdvertiserOrientationController;
use App\Http\Controllers\Api\ApplicationDataController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankAccountController;
use App\Http\Controllers\Api\BlockUserController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\EstateTypeController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\FollowerController;
use App\Http\Controllers\Api\MarketerController;
use App\Http\Controllers\Api\NeighborhoodController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\ReportReasonController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SupportServiceAdsController;
use App\Http\Controllers\Api\SupportServiceController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\UsageTypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserSupportServiceController;
use App\Http\Controllers\Api\ValLicenseController;
use App\Http\Controllers\BankCalcController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\NafathController;
use App\Models\Sponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\FcmNotificationService;
/**************************************[Auth Routes ]*************************************************/
Route::post('login' , [AuthController::class , 'login']);
Route::post('register' , [AuthController::class , 'register']);

Route::get('get-profile' , [AuthController::class , 'getProfile']);
Route::post('update-profile' , [AuthController::class , 'updateProfile']);

Route::post('verify' , [AuthController::class , 'verify']);
Route::post('forget-password' , [AuthController::class , 'forgetPassword']);
Route::post('reset-password' , [AuthController::class , 'resetPassword'])->middleware('auth:api');

Route::post("nafath-callback", [NafathController::class , 'nafathCallback']);
Route::post("test/nafath-callback", [NafathController::class , 'testNafathCallback']);


Route::post("version", [SettingController::class , 'version']);


/*************************************[Global Data Routes]********************************************/
Route::get('sliders' , SliderController::class);
Route::get('areas' , AreaController::class);
Route::get('advertiserOrientation' , AdvertiserOrientationController::class);
Route::get('cities' , CityController::class);
Route::get('states' , StateController::class);
Route::get('neighborhoods' , NeighborhoodController::class);
Route::get('ad-types' , AdTypeController::class);
Route::get('user/ads/{user}' , [UserController::class , 'userAds']);
Route::get('usage-types' , UsageTypeController::class);
Route::get('estate-types' , EstateTypeController::class);
Route::get('types' , TypeController::class);
Route::get('stories/' , [StoryController::class , 'index'] );
Route::get('account-types' , AccountTypeController::class);
Route::get('reasons' , ReasonController::class);
Route::get('properties/{estateId?}/{typeId?}' , [PropertyController::class , 'index']);
Route::get('ads/buy' , [AdController::class , 'buyAds']);
Route::get('ads/sell' , [AdController::class , 'sellAds']);
Route::get('ads/map' , [AdController::class , 'mapIndex']);
Route::get('show-ad/{ad}' , [AdController::class , 'show']);
Route::get('user-profile/{user}' , [UserController::class , 'show']);
Route::get('services' , [ServiceController::class , 'index']);
Route::get('support-services' , [SupportServiceController::class , 'index']);
Route::get('support-service-status' , [SupportServiceController::class , 'status']);
Route::get('delete-acount-status' , [SettingController::class, 'deleteAcountStatus']);

//Route::get('users-support-services' , [\App\Http\Controllers\Api\SupportServiceController::class , 'getUsersSupportServices']);
//Route::get('users-support-services/{user_support_service}' , [\App\Http\Controllers\Api\SupportServiceController::class , 'show']);
Route::get('blogs' , [BlogController::class , 'index']);
Route::get('blogs/{blog}' , [BlogController::class , 'show']);
Route::get('companies' , [UserController::class , 'companies']);
Route::get('bank-accounts' , BankAccountController::class );
Route::get('subscriptions' , [SubscriptionController::class , 'index']);
Route::post('contact-us' , [ContactUsController::class , 'store']);
Route::post('donate' , [ContactUsController::class , 'donate']);
Route::post('coupons/check' , CouponController::class);
Route::get('ads' , [AdController::class , 'index']);
Route::get('support-service-ads' , [SupportServiceAdsController::class , 'index']);
Route::get('support-service-ads/{support_service_ad}' , [SupportServiceAdsController::class , 'show']);


Route::get('application-data' , ApplicationDataController::class);
Route::get('sponsors',fn()=>Sponser::all());

Route::group(['middleware'=>['auth:api' , 'is_active']], function (){
    /************************************************* Ads Requests ****************************************/
    Route::get('resend' , [UserController::class , 'resend']);
    Route::get('logout' , [AuthController::class , 'logout']);
    Route::get('delete-acount' , [AuthController::class , 'deleteAcount']);


    // ads license
    Route::post('check-ads-license' ,[AdController::class , 'checkAdsLicense']);
    Route::post('store-ad-sell' , [AdController::class , 'storeSell']);
    
    Route::post('store-ad' , [AdController::class , 'store']);

    //Nafath
    Route::post("nafath-request", [NafathController::class , 'send_request']);
    Route::get("nafath-status", [NafathController::class , 'nafath_status']);


    //stories
    Route::get('stories/{ad}' , [StoryController::class , 'show'] );
    Route::get('stories/{ad}/toggle-like' , [StoryController::class , 'toggleLike'] );

    // val license
    Route::post('val-license' ,[ValLicenseController::class , 'store'])->middleware('validate-nafath-verification');

    Route::get('favourite-ads',[FavouriteController::class , 'index']);
    Route::get('add-to-favourite/{adId}',[FavouriteController::class , 'store']);
    Route::get('remove-from-favourite/{adId}',[FavouriteController::class , 'destroy']);
    Route::get('show-update-sell-ad/{adId}' , [AdController::class , 'showForUpdate']);
    Route::post('update-ad/{ad}' , [AdController::class , 'update']);
    Route::get('delete-ad/{ad}' , [AdController::class , 'destroy']);
    Route::get('make-ad-special/{ad}' , [AdController::class , 'makeAdSpecial']);
    Route::get('republish/{ad}' , [AdController::class , 'rePublish']);
    Route::get('ads/delete-image' , [AdController::class , 'deleteImage']);
    Route::get('ads/refresh/{ad}' , [AdController::class , 'refresh']);

    Route::get('report-reasons' , ReportReasonController::class);
    Route::post('report-ad/{ad}' , [AdController::class , 'report']);
    Route::post('cellation-ad/{adId}' , [AdController::class , 'Adcancellation']);
    Route::post('update-sell-ad/{ad}' , [AdController::class , 'updateSell']);
    Route::post('change-password' , [UserController::class , 'changePassword']);
    Route::get('delete-account' , [UserController::class , 'deleteAccount']);



    /************************************************** User Requests***************************************/
    Route::post('user/update' , [UserController::class , 'update']);
    Route::post('user-verify' , [UserController::class , 'verifyUser']);
    Route::get('user-followers' , [FollowerController::class , 'index']);
    Route::get('user-follow/{user}' , [FollowerController::class , 'follow']);
    Route::get('user-unfollow/{user}' , [FollowerController::class , 'unFollow']);
    Route::get('user/ads' , [UserController::class , 'ads']);
    Route::get('user/support-ads' , [UserController::class , 'support_ads']);


    Route::get('user-blocks' , [BlockUserController::class , 'index']);
    Route::get('user-block/{user}' , [BlockUserController::class , 'store']);
    Route::get('user-unblock/{user}' , [BlockUserController::class , 'destroy']);

    Route::post('subscription/store' , [SubscriptionController::class , 'store']);
    Route::post('subscription/store-free' , [SubscriptionController::class , 'storeFree']);
    Route::post('subscription/update' , [SubscriptionController::class , 'update']);
    Route::post('subscription/services/update' , [SubscriptionController::class , 'updateServices']);
    Route::post('subscription/services/delete' , [SubscriptionController::class , 'deleteServices']);

    Route::get('subscription/delete-image' , [SubscriptionController::class , 'deleteImage']);



    /* Bank Calculations */
    Route::post("bank-calculations" , [BankCalcController::class , 'store']);
    Route::get("bank-calculations" , [BankCalcController::class , 'index']);
    Route::get("bank-calculations/jobs" , [BankCalcController::class , 'jobs']);


    /* User Services */

//    Route::apiResource('user-support-services' , \App\Http\Controllers\Api\UserSupportServiceController::class);
    Route::get('user-support-services' , [UserSupportServiceController::class , 'index']);
    Route::post('user-support-services' , [UserSupportServiceController::class , 'store']);
    Route::post('user-support-services/{user_support_service}' , [UserSupportServiceController::class , 'update']);
    Route::delete('user-support-services/{user_support_service}' , [UserSupportServiceController::class , 'destroy']);
//    Route::get('user-services/{user_service}' , [\App\Http\Controllers\Api\UserHelperServiceController::class , 'show']);
    /* User Service Ads */
    Route::post('support-service-ads' , [SupportServiceAdsController::class , 'store']);
    Route::post('support-service-ads/{support_service_ad}' , [SupportServiceAdsController::class , 'update']);
    Route::delete('support-service-ads/{support_service_ad}' , [SupportServiceAdsController::class , 'destroy']);

    /************************************  Chat Routes ************************************************************/
    Route::get('chats/index' , [ChatController::class , 'index']);
    Route::get('chats/{chat}' , [ChatController::class , 'show']);
    Route::post('chats/send-message' , [ChatController::class , 'store']);


    Route::get('toggle/{disable}' , [UserController::class , 'toggle']);





    Route::get('marketers/get-profile' , [MarketerController::class , 'getProfile']);
    Route::get('marketers/get-users' , [MarketerController::class , 'getUsers']);
    Route::get('marketers/get-transactions' , [MarketerController::class , 'getTransactions']);
    Route::post('marketers/withdrawal-request' , [MarketerController::class , 'StoreWithdrawal']);



});

