<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAdRequest;
use App\Http\Requests\Api\StoreAdSellRequest;
use App\Http\Requests\Api\UpdateAdRequest;
use App\Http\Requests\Api\UpdateAdSellRequest;
use App\Http\Requests\Api\CheckAdsLicenseRequest;
use App\Http\Resources\AdCollection;
use App\Http\Resources\AdResource;
use App\Http\Resources\MapAdResource;
use App\Http\Resources\SingleAdResource;
use App\Http\Resources\SingleAdForUpdateResource;
use App\Models\Ad;
use App\Models\AdAttachment;
use App\Models\Setting;
use App\Models\AdType;
use App\Models\EstateType;
use App\Models\Neighborhood;
use App\Models\Area;
use App\Models\City;
use App\Models\Reason;
use App\Models\AdPlatform;
use App\Models\AdReport;

use App\Services\AdService;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdController extends Controller
{
    use ResponseTrait;

    protected $adService;
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
        $this->middleware('check-user-balance')->only(['store']);
    }

    public function index(Request $request)
    {

        $nearestSellAds = server_cache('nearest_ads','long',fn()=>
            Ad::with("user")->limitWhen($request->limit)->sell()->filterAds($request->query())->nearest()->withAll()->get()
        );
        $latestSellAds = server_cache('latest_ads','long',fn()=>
            Ad::with("user")->limitWhen($request->limit)->sell()->filterAds($request->query())->orderBySpecial()->withAll()->get()
        );
        $buyAds = server_cache('index_buy_ads','long',fn()=>
            Ad::with("user")->limitWhen($request->limit)->buy()->filterAds($request->query())->orderBySpecial()->withAll()->get()
        );

        return $this->successResponse('', [
            'sell' => [
                'nearest' => AdResource::collection($nearestSellAds),
                'latest' => AdResource::collection($latestSellAds),
            ],
            'buy' => AdResource::collection($buyAds),
        ]);
    }

    public function sellAds(Request $request)
    {
        $ads = server_cache('sell_ads','long',fn()=>
            Ad::sell()->filterAds($request->query())
                ->orderBySpecial()->nearest()
                ->withAll()->withCount(['storyViews','storyLikes'])->paginate(request('perPage') ?? 10 )
        );
        return $this->successResponse(data: new AdCollection($ads));
    }

    public function buyAds(Request $request)
    {
        $ads = server_cache('buy_ads','long',fn()=>
            Ad::buy()->filterAds($request->query())
                ->withCount('visits')->orderBySpecial()->withAll()
                ->withCount(['storyViews','storyLikes'])
                ->latest()->paginate(request('perPage') ?? 10)
        );
        return $this->successResponse(data: new AdCollection($ads));
    }

    public function mapIndex(Request $request)
    {
        $ads = server_cache('map_ads','long',fn()=>
            Ad::sell()->filterAds($request->query())->with(['city', 'adType', 'attachments', 'estateType'])->get()
        );
        return $this->successResponse('', [
            'ads' => MapAdResource::collection($ads),
        ]);
    }

    public function show(Request $request, Ad $ad)
    {
        if ($request->hasHeader('device-token')) {
            $ad->visits()->firstOrCreate(['device_token' => $request->header('device-token')]);
        }
        $operationType='DisplayAd';
        $operationReason='Other';
        $response = $this->adService->FeedbackTranslation($ad,$operationType,$operationReason);
        $ad->loadCount('visits');

        $related_ads = $this->adService->getRelated($ad);

        return $this->successResponse('', ['ad' => SingleAdResource::make($ad), 'related_ads' => AdResource::collection($related_ads)]);
    }

    public function store(StoreAdRequest $request)
    {
        
       $user= auth()->user();
//        if ($request->is_story == 1) {
//            if (auth()->user()->subscription()->wherePivot('is_active', 1)->first()?->id != 9 && auth()->user()->ads()->where('is_story', 1)->count() > 0) {
//                return $this->failedResponse(__('no_story_available_for_this_user'));
//            }
//        }

        $adData = $request->safe()->except(['attachment', 'options']);

        if(!$request->special){
            $adData['special'] = 0;
        }
        $adData['main_type']='buy';
        if ($adData['neighborhood_id'] == 'null' || $adData['neighborhood_id'] == null) {
            unset($adData['neighborhood_id']);
        }
      
        
        $this->adService->createAd($adData, $request->attachment, $request->options);
        return $this->successResponse(__('created_successfully'));
    }
    
     public function storeSell(StoreAdSellRequest $request)
    {
        
       $user= auth('api')->user();
//        if ($request->is_story == 1) {
//             if (auth()->user()->subscription()->wherePivot('is_active', 1)->first()?->id != 9 && auth()->user()->ads()->where('is_story', 1)->count() > 0) {
//                return $this->failedResponse(__('no_story_available_for_this_user'));
//             }
//        }
        $ad=Ad::where('license_number' , $request->license_number)->exists();
        if($ad){
            $ad_first=Ad::where('license_number' , $request->license_number)->first();
            $data['id']=$ad_first->id;
            $data['user_name']=$ad_first->user?$ad_first->user->name:'';
         return $this->failedWithDataResponse(__('The_ad_has_been_added_before'),$data,201);   
        }
        $adData = $request->safe()->except(['attachment', 'options']);

        if(!$request->special){
            $adData['special'] = 0;
        }
        $idType= $user->identity_type;
        $advertiserId=  $idType == 1 ? $user->identity_number : $user->unified_number;
        $AdvertisementChecked=$this->adService->AdvertisementChecked($request->license_number,$advertiserId,$idType);
        if(!$AdvertisementChecked['Status']){
           return $this->failedResponse($AdvertisementChecked['message']);
        }
        $local= app()->getLocale();
        $ad_type= AdType::whereTranslation('name', $AdvertisementChecked['Body']['result']['advertisement']['advertisementType'])->first();
        $estate_type=EstateType::whereTranslation('name', $AdvertisementChecked['Body']['result']['advertisement']['propertyType'])->first();
        $city=City::whereTranslation('name', $AdvertisementChecked['Body']['result']['advertisement']['location']['city'])->first();
        $area=Area::whereTranslation('name', $AdvertisementChecked['Body']['result']['advertisement']['location']['region'])->first();
        $neighborhood=Neighborhood::where('city_id',$city->id)->whereTranslation('name',$AdvertisementChecked['Body']['result']['advertisement']['location']['district'])->first();
        $adData['main_type']='sell';
        $adData['city_id']=$city ? $city->id : City::first()->id;
        $adData['neighborhood_id']=$neighborhood ? $neighborhood->id : Neighborhood::first()->id;
        $adData['area_id']=$area ? $area->id : Area::first()->id;
        $adData['estate_type_id']=$estate_type ? $estate_type->id : 1;
        $adData['ad_type_id']=$ad_type ? $ad_type->id : 1;
        $adData['price']=convert_to_english_numbers($AdvertisementChecked['Body']['result']['advertisement']['propertyPrice']);
        $adData['lat']=$AdvertisementChecked['Body']['result']['advertisement']['location']['latitude']?:"21.422510";
        $adData['lng']=$AdvertisementChecked['Body']['result']['advertisement']['location']['longitude']?:"39.826168";
        $adData['location']= $AdvertisementChecked['Body']['result']['advertisement']['location']['region'] .'-'.$AdvertisementChecked['Body']['result']['advertisement']['location']['city'].'-'.$AdvertisementChecked['Body']['result']['advertisement']['location']['district'].'-'.$AdvertisementChecked['Body']['result']['advertisement']['location']['street'];
        //  $adData['advertiser_orientation_id'] =  ['required' , 'exists:adv_orientations,id'],
        //     'advertiser_type'           =>  [ 'required'  ,'in:owner,delegate'],
        if($AdvertisementChecked['Body']['result']['advertisement']['landTotalAnnualRent']){
            $adData['price']=convert_to_english_numbers($AdvertisementChecked['Body']['result']['advertisement']['landTotalAnnualRent']);
        }elseif($AdvertisementChecked['Body']['result']['advertisement']['landTotalPrice']){
            $adData['price']=convert_to_english_numbers($AdvertisementChecked['Body']['result']['advertisement']['landTotalPrice']);
        }
        $adData['area']=$AdvertisementChecked['Body']['result']['advertisement']['propertyArea'];
        if($request->options == null ){
            $options=[];
        }else{
             $options=$request->options;
        }
        $this->adService->createAd($adData, $request->attachment, $options,$AdvertisementChecked);
        
        return $this->successResponse(__('created_successfully'));
    }
    
    public function checkAdsLicense( CheckAdsLicenseRequest $request)
    {
        
        $user= auth()->user();
        $idType= $user->identity_type;
        $advertiserId= $idType == 1 ? $user->identity_number : $user->unified_number;
        
        if(!$advertiserId){
            return $this->failedResponse(__('Please_add_your_ID_number_and_type'),502);
        }
        $ad=Ad::where('license_number' , $request->license_number)->exists();
        if($ad){
            $ad_first=Ad::where('license_number' , $request->license_number)->first();
            $data['id']=$ad_first->id;
            $data['user_name']=$ad_first->user?$ad_first->user->name:'';
         return $this->failedWithDataResponse(__('The_ad_has_been_added_before'),$data,201);   
        }
        
         $AdvertisementChecked=$this->adService->AdvertisementChecked($request->license_number,$advertiserId,$idType);
        if(!$AdvertisementChecked['Status']){
           return $this->failedResponse($AdvertisementChecked['message']);
        }
        $data['propertyPrice']=$AdvertisementChecked['Body']['result']['advertisement']['propertyPrice'];
        $data['advertiserId']=$AdvertisementChecked['Body']['result']['advertisement']['advertiserId'];
        $data['propertyArea']=$AdvertisementChecked['Body']['result']['advertisement']['propertyArea'];
        $data['advertiserName']=$AdvertisementChecked['Body']['result']['advertisement']['advertiserName'];
        $data['phoneNumber']=$AdvertisementChecked['Body']['result']['advertisement']['phoneNumber'];
        $data['deedNumber']=$AdvertisementChecked['Body']['result']['advertisement']['deedNumber'];
        
        $data['propertyType']=$AdvertisementChecked['Body']['result']['advertisement']['propertyType'];
        $type=EstateType::whereTranslation('name',$data['propertyType'])->first();
        $data['propertyTypeId']=$type ? $type->id : EstateType::first()->id;

        $data['propertyAge']=$AdvertisementChecked['Body']['result']['advertisement']['propertyAge'];
        
        $data['isPawned']=$AdvertisementChecked['Body']['result']['advertisement']['isPawned'];
        $data['isConstrained']=$AdvertisementChecked['Body']['result']['advertisement']['isConstrained'];
        
        $data['advertisementType']=$AdvertisementChecked['Body']['result']['advertisement']['advertisementType'];
        $data['numberOfRooms']=$AdvertisementChecked['Body']['result']['advertisement']['numberOfRooms'];
        $data['district']=$AdvertisementChecked['Body']['result']['advertisement']['location']['district'];
        $data['city']=$AdvertisementChecked['Body']['result']['advertisement']['location']['city'];
        $data['region']=$AdvertisementChecked['Body']['result']['advertisement']['location']['region'];
        
        $data['districtCode']=$AdvertisementChecked['Body']['result']['advertisement']['location']['districtCode'];
        $data['cityCode']=$AdvertisementChecked['Body']['result']['advertisement']['location']['cityCode'];
        $data['regionCode']=$AdvertisementChecked['Body']['result']['advertisement']['location']['regionCode'];
        
        $data['latitude']=$AdvertisementChecked['Body']['result']['advertisement']['location']['latitude']?:"21.422510";
        $data['longitude']=$AdvertisementChecked['Body']['result']['advertisement']['location']['longitude']?:"39.826168";
        
        $data['isHalted']=$AdvertisementChecked['Body']['result']['advertisement']['isHalted']; 
        $data['isTestment']=$AdvertisementChecked['Body']['result']['advertisement']['isTestment']; 
        $data['rerConstraints']=$AdvertisementChecked['Body']['result']['advertisement']['rerConstraints']; 
        $data['landTotalPrice']=$AdvertisementChecked['Body']['result']['advertisement']['landTotalPrice']; 
        $data['landTotalAnnualRent']=$AdvertisementChecked['Body']['result']['advertisement']['landTotalAnnualRent']; 
        $data['landNumber']=$AdvertisementChecked['Body']['result']['advertisement']['landNumber']; 
        $data['adLicenseUrl']=$AdvertisementChecked['Body']['result']['advertisement']['adLicenseUrl']; 
        $data['adSource']=$AdvertisementChecked['Body']['result']['advertisement']['adSource']; 
        $data['titleDeedTypeName']=$AdvertisementChecked['Body']['result']['advertisement']['titleDeedTypeName']; 
        $data['locationDescriptionOnMOJDeed']=$AdvertisementChecked['Body']['result']['advertisement']['locationDescriptionOnMOJDeed']; 
        $data['notes']=$AdvertisementChecked['Body']['result']['advertisement']['notes']; 
        $data['borders']=$AdvertisementChecked['Body']['result']['advertisement']['borders'];  
        $data['rerBorders']=$AdvertisementChecked['Body']['result']['advertisement']['rerBorders'];
        return $this->successResponse('',$data);
    }
    
     public function showForUpdate(Request $request, $ad_id)
    {
        $user= auth()->user();
        
        $ad=$user->ads->where('id',$ad_id)->first();
        if(!$ad){
          return $this->failedResponse(__('ad_not_found'));
        }
            
        $operationType='DisplayAd';
        $operationReason='Other';
        $response = $this->adService->FeedbackTranslation($ad,$operationType,$operationReason);
        // if(!$response['Status']){
        //   return $this->failedResponse($response['message']);
        // }
        
        
        $Advertisement=AdPlatform::where('ad_id',$ad_id)->first();
        if(!$Advertisement){
          return $this->failedResponse(__('ad_not_found'));
        }
        $Advertisement=json_decode($Advertisement->data, true);
        $data=[];
        $data['propertyPrice']=$Advertisement['propertyPrice'];
        $data['advertiserId']=$Advertisement['advertiserId'];
        $data['propertyArea']=$Advertisement['propertyArea'];
        $data['advertiserName']=$Advertisement['advertiserName'];
        $data['phoneNumber']=$Advertisement['phoneNumber'];
        $data['deedNumber']=$Advertisement['deedNumber'];
        
        $data['propertyType']=$Advertisement['propertyType'];
        $type=EstateType::whereTranslation('name',$data['propertyType'])->first();
        $data['propertyTypeId']=$type ? $type->id : EstateType::first()->id;

        $data['propertyAge']=$Advertisement['propertyAge'];
        
        $data['isPawned']=$Advertisement['isPawned'];
        $data['isConstrained']=$Advertisement['isConstrained'];
        
        $data['advertisementType']=$Advertisement['advertisementType'];
        $data['numberOfRooms']=$Advertisement['numberOfRooms'];
        $data['district']=$Advertisement['location']['district'];
        $data['city']=$Advertisement['location']['city'];
        $data['region']=$Advertisement['location']['region'];
        
        $data['districtCode']=$Advertisement['location']['districtCode'];
        $data['cityCode']=$Advertisement['location']['cityCode'];
        $data['regionCode']=$Advertisement['location']['regionCode'];
        
        $data['latitude']=$Advertisement['location']['latitude']?:"21.422510";
        $data['longitude']=$Advertisement['location']['longitude']?:"39.826168";
        
        $data['isHalted']=$Advertisement['isHalted']; 
        $data['isTestment']=$Advertisement['isTestment']; 
        $data['rerConstraints']=$Advertisement['rerConstraints']; 
        $data['landTotalPrice']=$Advertisement['landTotalPrice']; 
        $data['landTotalAnnualRent']=$Advertisement['landTotalAnnualRent']; 
        $data['landNumber']=$Advertisement['landNumber']; 
        $data['adLicenseUrl']=$Advertisement['adLicenseUrl']; 
        $data['adSource']=$Advertisement['adSource']; 
        $data['titleDeedTypeName']=$Advertisement['titleDeedTypeName']; 
        $data['locationDescriptionOnMOJDeed']=$Advertisement['locationDescriptionOnMOJDeed']; 
        $data['notes']=$Advertisement['notes']; 
        $data['borders']=$Advertisement['borders'];  
        $data['rerBorders']=$Advertisement['rerBorders'];
        return $this->successResponse('', ['ad' => new SingleAdForUpdateResource($ad),'ad_platform' =>$data]);
    }
    public function updateSell(UpdateAdSellRequest $request,  Ad $ad)
    {
        $adData = $request->safe()->except(['attachments','files_removed','videos']);
        if ($request->attachments) {
            $this->adService->uploadAttachment($ad, $request->attachments);
        }
        if($request->videos){
            // $this->adService->removeVideo($ad);
            $this->adService->uploadAttachment($ad, $request->videos);
        }
        if($request->files_removed){
            $this->adService->removeAttachment($request->files_removed);
        }
        $ad->update($adData);
        return $this->successResponse(__('updated_successfully'));

    }
    public function update(UpdateAdRequest $request, Ad $ad)
    {
        $adData = $request->safe()->except('attachment');
        if ($request->attachment) {
            $this->adService->uploadAttachment($ad, $request->attachment);
        }

        $ad->update($adData);
        return $this->successResponse(__('updated_successfully'));

    }

    public function report(Request $request, Ad $ad)
    {
        $reportReasonId = $request->validate(['report_reason_id' => 'required|exists:report_reasons,id'])['report_reason_id'];
        $ad_r=AdReport::create([
            'report_reason_id' => $reportReasonId,
            'user_id' => auth()->id(),
            'ad_id' =>$ad->id
            ]);
        // $ad->reports()->create([]);
        $message = "تم الإبلاغ عن الإعلان رقم : " . $ad->id;
        \App\Services\AdminNotification::create($message, route('dashboard.adReports.index',[],false),$ad_r->id);
        return $this->successResponse(__('report_successfully'));
    }

    public function makeAdSpecial(Ad $ad)
    {
        $user = auth()->user();
        $subscription = $user->subscription()->first();

        if ($ad->special) {
            return $this->failedResponse(__('already_special'));
        }

        if ($subscription?->pivot->special_ads > 0) {
            $subscription->pivot->special_ads = $subscription->pivot->special_ads - 1;
            $subscription->pivot->save();
            $ad->special = 1;
            $ad->save();
        } else {
            return $this->failedResponse(__('no_special_balance'));
        }
        return $this->successResponse(__('updated_successfully'));
    }

    public function rePublish(Ad $ad)
    {
        $user = auth()->user();
        $subscription = $user->subscription()->first();
        if ($subscription?->pivot->regular_ads >= 1) {
            $subscription->pivot->regular_ads = $subscription->pivot->regular_ads - 1;
            $subscription->pivot->save();
            $ad->active = 1;
            $ad->save();
        } else if ($user->free_ads >= 1) {
            $user->decrement('free_ads', 1);
            $ad->active = 1;
            $ad->save();
        } else {
            return $this->failedResponse(__('no_balance'));
        }

        return $this->successResponse(__('republished_successfully'));
    }

    public function refresh(Ad $ad)
    {
        $date = Carbon::parse($ad->refresh_date);
        $now = Carbon::now();
        $days = Setting::first()?->refresh_ad_limit ?? 15;
        if ($now->diffInDays($date) <= $days) {
            return $this->failedResponse(__('refresh_failed'));
        }

        $ad->update([
            'refresh_date' => $now,
        ]);

        return $this->successResponse(__('refresh_success'));
    }

    public function deleteImage(Request $request)
    {
        AdAttachment::where('link', str_replace('https://aqarcom.sa/uploads/', '', $request->link))->delete();
        return $this->successResponse(__('deleted_successfully'));
    }

    public function Adcancellation(Request $request , $ad_id)
    {
        $user = auth()->user();
        $reason_id = $request->validate(['reason_id' => 'required|exists:reasons,id'])['reason_id'];
        $ad=Ad::where('user_id',$user->id)->where('id',$ad_id)->first();
        if(!$ad){
          return $this->failedResponse(__('ad_not_found'));
        }
        
        $reason=  Reason::whereId($reason_id)->first();
        $operationType='CancelAd';
        $operationReason=$reason->type;
        $response = $this->adService->FeedbackTranslation($ad,$operationType,$operationReason);
        // if error code 
        // if(!$response['Status']){
        //   return $this->failedResponse($response['message']);
        // }
        $ad->active = 0;
        $ad->is_cancelled = 1;
        $ad->reason_id = $reason_id;
        $ad->save(); 
        
            
        return $this->successResponse(__('cancellation_successfully'));
    }
    
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return $this->successResponse(__('deleted_successfully'));
    }
}
