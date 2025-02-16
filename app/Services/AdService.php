<?php


namespace App\Services;

use App\Models\Ad;
use App\Models\AdPlatform;
use App\Models\AdAttachment;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class AdService {
    use ResponseTrait;
    public function createAd(array $ad_data ,?array $attachments , ?array $options):void
    {
        $ad_data['user_id'] = auth('api')->id();
        DB::transaction(function () use ($ad_data , $attachments ,$options){
            $ad = Ad::create($ad_data);
            if($ad_data['main_type'] == 'sell'){
                $this->uploadAttachment($ad , $attachments);
                $this->assignOptionsToAd($ad , $options);
                
                $user= auth()->user();
                $idType= $user->identity_type;
                $advertiserId=  $idType == 1 ? $user->identity_number : $user->unified_number;
                $data_ad=$this->AdvertisementChecked($ad->license_number,$advertiserId,$idType);
                AdPlatform::create([
                    'ad_id'=>$ad->id,
                    'adLicenseNumber'=>$ad->license_number,
                    'data'=>json_encode($data_ad['Body']['result']['advertisement'])
                ]);
            }

            $this->decreaseAdsBalance($ad_data);
           
        });

    }

    public function uploadAttachment( $ad , ?array $attachment):void
    {
        foreach ((array)$attachment as $file){
            $getMimeType=  $file->getMimeType();
            if(str_starts_with($getMimeType,'image/')){
                $extension_file='png';
            }else{
                $extension_file='mp4';
            }
            AdAttachment::create([
                'link'=>file_uploader($file , 'ads'),
                'extension_file'=>$extension_file,
                'ad_id'=>$ad->id,
            ]);
        }
    }
    public function removeAttachment($attachments):void
    {
          
        foreach ((array)$attachments as $attachment){
          $ad_attachment=  AdAttachment::where('id',$attachment)->first();
          if($ad_attachment){
             deleteFiles([$ad_attachment->link]);
            $ad_attachment->delete();
          }
        }
    }
    
    /*
    * removed video for ad
    *
    *
    */
     public function removeVideo($ad):void
    {
         $at_video= AdAttachment::where('ad_id',$ad->id)->where('extension_file','mp4')->get();
        foreach($at_video as $video){
            deleteFiles([$video->link]);
            $video->delete();
        }
    }
    public function assignOptionsToAd(Ad $ad , ?array $options)
    {
        foreach ($options as $index => $option){
            $options[$index]['values'] = json_encode(array_values($option['values']));
        }
        $ad->options()->attach($options);
    }
    public function decreaseAdsBalance($ad_data): void
    {
        $user = auth()->user();
        $subscription = $user->subscription()->first();
//        dd($subscription?->pivot->special_ads,$subscription?->pivot->regular_ads,$user->free_ads,(bool)$ad_data['special']);
        if((bool)$ad_data['special'] ){
            if($subscription?->pivot->special_ads<1){
                throw new HttpResponseException($this->failedResponse(__('no_special_balance')));
            }
            $subscription->pivot->special_ads = $subscription->pivot->special_ads-1;
            $subscription->pivot->save();

        }else if($subscription?->pivot->regular_ads>=1){
            $subscription->pivot->regular_ads = $subscription->pivot->regular_ads-1;
            $subscription->pivot->save();
        }else if($user->free_ads>=1){
            $user->decrement('free_ads' ,1);
        }else{
            throw new HttpResponseException($this->failedResponse(__('no_balance')));
        }
    }


    public function getRelated(Ad $ad)
    {
        return Ad::where([['city_id' , '=' , $ad->city_id],['main_type' , '=' , $ad->main_type],['ad_type_id' , '=' , $ad->ad_type_id],
            ['usage_type_id' , '=' , $ad->usage_type_id],['estate_type_id' , '=' , $ad->estate_type_id] , ['id' , '<>' , $ad->id]])
            ->without(['user','city','adType','estateType','options','attachments'])
            ->get();
    }
    
    
     public function AdvertisementChecked($adLicenseNumber,$advertiserId,$idType)
    {
        
        $data=[];
        $ClientId=env('X_IBM_Client_Id');
        $ClientSecret=env('X_IBM_Client_Secret');
        $URL=env('X_IBM_Client_URL');
        $url = $URL."/v2/brokerage/AdvertisementValidator?adLicenseNumber={$adLicenseNumber}&advertiserId={$advertiserId}&idType={$idType}";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "RefId: 1",
            "X-IBM-Client-Id: {$ClientId}",
            "X-IBM-Client-Secret: {$ClientSecret}"
        ];
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        $response_json = json_decode($response, true);
        $data['Status']=false;
        $data['message']=__('Something went wrong');
        if(isset($response_json['Header'])){
            if($response_json['Header']['Status']['Code'] == 200){
                $data['Status']=$response_json['Body']['result']['isValid'];
                $data['message']=$response_json['Header']['Status']['Description'] != "OK"?: $response_json['Body']['result']['message'] ;
                $data['Body']=$response_json['Body'] ;
            }elseif($response_json['Header']['Status']['Code'] != 200){
                $data['Status']=false;
                $data['message']= __('Please check the licensing information');
            }
        }
        return $data;
    }
    
    
    
    public function FeedbackTranslation($ad, $operationType, $operationReason)
    {
        $ClientId = env('X_IBM_Client_Id');
        $ClientSecret = env('X_IBM_Client_Secret');
        $platformOwnerId = env('X_platformOwnerId');
        $platformId = env('X_platformId');
        $adLinkInPlatform = env('X_adLinkInPlatform');
        $url = env('X_IBM_Client_URL') . "/v1/brokerage/PlatformCompliance";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "RefId: 1",
            "X-IBM-Client-Id: {$ClientId}",
            "X-IBM-Client-Secret: {$ClientSecret}"
        ];
        $data['Status']=true;
        $data['message']=__('Something went wrong');
        
        
        $AdPlatform = AdPlatform::where('ad_id',$ad->id)->first();

        
        if($AdPlatform){
                $old_data=json_decode($AdPlatform->data, true);
                $inputData = [
            "platformOwnerId" => $platformOwnerId,
            "platformId" => $platformId,
            "operationType" => $operationType,
            "operationReason" =>$operationReason,
            "adLinkInPlatform" => $adLinkInPlatform.$ad->id,
            "adLicenseNumber" => $old_data['adLicenseNumber'],
            "brokerageAndMarketingLicenseNumber" => $old_data['brokerageAndMarketingLicenseNumber'],
            "creationDate" => $old_data['creationDate'],
            "endDate" => $old_data['endDate'],
            
            "advertiserId" =>  $old_data['advertiserId'],
            "advertiserName" => $old_data['advertiserName'],
            "advertiserMobile" => $old_data['phoneNumber'],
            "channels" => $old_data["channels"],
            "nationalAddress" => [
                "region" => $old_data["location"]['region'],
                "city" => $old_data["location"]['city'],
                "district" => $old_data["location"]['district'],
                "postalCode" =>$old_data["location"]['postalCode'],
                "streetName" => $old_data["location"]['street'],
                "buildingNo" => $old_data["location"]['buildingNumber'],
                "additionalNo" => $old_data["location"]['additionalNumber'],
                "adMapLongitude"=> $old_data["location"]['longitude'],
                "adMapLatitude"=> $old_data["location"]['latitude'],
            ],
            "propertyType" => $old_data['propertyType'],
            "propertyArea" =>$old_data['propertyArea'],
            "propertyUsage" =>$old_data['propertyUsages'],
            "streetWidth" =>$old_data['streetWidth'],
            "propertyAge" => $old_data['propertyAge'],
            "price" => $old_data['propertyPrice'],
            "propertyUtilities"=>$old_data['propertyUtilities'],
            "adType" => $old_data['advertisementType'],
            "constraints" => $old_data['rerConstraints'],
            "obligationsOnTheProperty" => $old_data['obligationsOnTheProperty'],
            "guaranteesAndTheirDuration" => $old_data['guaranteesAndTheirDuration'],
            "planNumber" =>  $old_data['planNumber'],
            "landNumber" =>  $old_data['landNumber'],
            "complianceWithTheSaudiBuildingCode" =>$old_data['complianceWithTheSaudiBuildingCode'],
            "qrCode" => "",
            "titleDeedType" => $old_data['titleDeedTypeName'],
            "TitleDeedNumber" => $old_data['deedNumber'],// رقم وثيقة الملكية
            "adLicenseUrl" => $old_data['adLicenseUrl'],// مصدر ترخيص  الاعلان
            "adSource" => $old_data['adSource'],// مصدر ترخيص  الاعلان
        ];
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($inputData));
                
                $response = curl_exec($curl);
                $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                 
                curl_close($curl);
                $response_json = json_decode($response, true);
                if(isset($response_json['Header'])){
                    if($response_json['Header']['Status']['Code'] == 200){
                        $data['Status']=$response_json['Body']['result']['response'];
                        $data['message']=$response_json['Body']['result']['message'];
                        $data['Body']=$response_json['Body'] ;
                    }else{
                        $data['Status']=$response_json['Body']['result']['response'];
                        $data['message']=$response_json['Body']['result']['message'];
                    }
                }
                return $data;
        
        }
       
    }

}
