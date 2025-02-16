<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceCityRequest;
use App\Http\Requests\Api\StoreSubscriptionRequest;
use App\Http\Requests\Api\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Coupon;
use App\Models\Marketer;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\MarketerTransaction;
use App\Services\PaymentService;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $subscriptions = server_cache(class_basename(Subscription::class), 'long', fn() =>
                Subscription::where('status',true)->with(['translation'])->orderBy('price')->get()
        );


        $commission_status = (bool)Setting::first()->commission_status;
        return $this->successResponse(data: SubscriptionResource::collection($subscriptions),extra:['commission_status'=>$commission_status]);
    }

    public function store(StoreSubscriptionRequest $request)
    {
        
    
        
        //Check if user has a subscription and add the old balance to new subscription
        $oldSubscription = auth()->user()->subscription()->first();
        $user = auth()->user();

        // User Has pending Subscription ....
        if ($oldSubscription && !$oldSubscription->pivot->is_active) {
            return $this->failedResponse(__('has_pending_subscription'));
        }
                $subscription = Subscription::find($request->subscription_id);
       $oldSubscriptionThis= auth()->user()->subscription()->where('subscription_id',$subscription->id)->first();
        if($oldSubscriptionThis && $oldSubscriptionThis->end_date <  Carbon::now()){
            return $this->failedResponse(__('You are already subscribed to this package'));
        }

        //Get The Data of Subscription and fill it .
        $price = $subscription->price;
        $coupon = $request->coupon;
        $marketer=null;
        if ($coupon) {
            $marketer = Marketer::where('code', $coupon)->whereJsonContains('subscription_ids', (string) $subscription->id)
                ->first();
            if ($marketer) {
                $price = $marketer->new_price($price);
            } else {
                $coupon = Coupon::findByCode($coupon , $subscription->id);
                if ($coupon) {
                    $price = $coupon->new_price($price);
                }
            }
        }
        
        
        if($price <= 0){
          
            $subscriptionData['regular_ads'] = $subscription->regular_ads + (int) $oldSubscription?->pivot?->regular_ads;
            $subscriptionData['special_ads'] = $subscription->special_ads + (int) $oldSubscription?->pivot?->special_ads;
            $subscriptionData['end_date'] = Carbon::now()->addDays($subscription->duration);
            $subscriptionData['coupon'] = $request->coupon;
            $subscriptionData['price'] = 0;
            $subscriptionData['is_active'] = 1;
            $subscriptionData['payment_id'] =null;
            auth()->user()->subscription()->sync([$subscription->id => $subscriptionData]);
          if($marketer){
              MarketerTransaction::create([
                  'user_id'=>auth()->user()->id,
                  'marketer_id'=>$marketer->id,
                  'subscription_id'=>$subscription->id,
                  'payment_id'=>null,
                  'amount'=>$price
                  ]);
          }
            return $this->successResponse(__('subscribe_successfully'),data: [
                'url' => null,
            ]);
        }
        if ($request->payment_method == 'bank') {
            $subscriptionData['regular_ads'] = $subscription->regular_ads + (int) $oldSubscription?->pivot?->regular_ads;
            $subscriptionData['special_ads'] = $subscription->special_ads + (int) $oldSubscription?->pivot?->special_ads;
            $subscriptionData['end_date'] = Carbon::now()->addDays($subscription->duration);
            $subscriptionData['coupon'] = $request->coupon;
            $subscriptionData['price'] = $price;
            $subscriptionData['is_active'] = 0;
            $subscriptionData['payment_id'] = PaymentService::createBankPayment(file_uploader($request->receipt, 'payments'));
            auth()->user()->subscription()->sync([$subscription->id => $subscriptionData]);
            if ($coupon instanceof Coupon) {
                $coupon->burn();
            }
        if($marketer){
              MarketerTransaction::create([
                  'user_id'=>auth()->user()->id,
                  'marketer_id'=>$marketer->id,
                  'subscription_id'=>$subscription->id,
                  'payment_id'=>$subscriptionData['payment_id'],
                  'amount'=>$price
                  ]);
          }
            $message = "يوجد طلب اشتراك جديد من العميل رقم : " . $user->id . " في " . $subscription->name;
            \App\Services\AdminNotification::create($message, route('dashboard.subscriptionRequests.index'));

        } else {
            $price = max([1, $price]);
            $url = route('payment.store', ['subscription', auth('api')->id(), $subscription->id, 'coupon' => $request->coupon]);
            return $this->successResponse(data: [
                'url' => route('payment.create', [$price, 'url' => $url, 'user_id' => $user->id]),
            ]);
        }
            
        return $this->successResponse(__('subscribe_successfully'),data: [
                'url' => null,
            ]);
    }

    public function uploadGallery(?array $images)
    {
        $uploadedImages = [];
        foreach ((array) $images as $key=>$image) {
            $uploadedImages[$key]['image'] = image_uploader_without_resize($image['image'], 'subscriptions');
            $uploadedImages[$key]['title'] = $image['title'];
        }

        return $uploadedImages;
    }

    public function update(UpdateSubscriptionRequest $request)
    {
        //  'name' => $this->name,
        //     'subscription_location' => $this->location,
        //     'regular_ads' => $this->pivot->regular_ads,
        //     'special_ads' => $this->pivot->special_ads,
        //     'about' => $this->pivot->about,
        //     'city_id' => $this->pivot->city_id,
        //     'gallery' => appendPathToImagesGallery(json_decode($this->pivot->gallery ?? "")),
        //     'location' => $this->pivot->location,
        //     'lng' => $this->pivot->lng,
        //     'lat' => $this->pivot->lat,
        $subscriptionData = $request->safe()->except(['gallery', 'services']);
        $user = auth()->user();
        $subscription = auth()->user()->subscription()->first();

        if ($request->gallery) {
            $images = (array) json_decode($subscription->pivot->gallery ?? "");
            $images = array_merge($images, $this->uploadGallery($request->gallery));
            $subscriptionData['gallery'] = json_encode($images);
        }

        $subscriptionData['facebook'] = $this->formatSocialLink($request->facebook);
        $subscriptionData['twitter'] = $this->formatSocialLink($request->twitter);
        $subscriptionData['snapchat'] = $this->formatSocialLink($request->snapchat);
        $subscriptionData['instagram'] = $this->formatSocialLink($request->instagram);
        $subscriptionData['linkedin'] = $this->formatSocialLink($request->linkedin);
        $subscriptionData['website'] = str_ireplace('https://', '', $request->website);

        auth()->user()->subscription()->sync([$subscription->id => $subscriptionData]);
        
        return $this->successResponse(__('updated_successfully'));

    }
    public function updateServices(ServiceCityRequest $request)
    {
        $request->validate([
            'service_ids' => 'required|array',
            'city_id' => 'required|exists:cities,id',
        ]);

        $user = auth()->user();
        $cityId = $request->city_id;
        if ($user->services()->wherePivot('city_id', $cityId)->exists()) {
            $user->services()->wherePivot('city_id', $cityId)->detach();
        }
        $user->services()->attach($request->service_ids, ['city_id' => $cityId]);
        return $this->successResponse(__('updated_successfully'));

    }

    public function deleteServices(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
        ]);

        $user = auth()->user();
        $cityId = $request->city_id;
        if ($user->services()->wherePivot('city_id', $cityId)->exists()) {
            $user->services()->wherePivot('city_id', $cityId)->detach();
        }
        return $this->successResponse(__('updated_successfully'));

    }

    public function deleteImage(Request $request)
    {
        $subscription = auth()->user()->subscription()->first();
        $images = json_decode($subscription->pivot->gallery);

        foreach ($images as $key => $image) {
            $image = is_object($image)?$image->image:$image;
            $db_image = explode("/",$image);
            $db_image_end = end($db_image);
            $link_image = explode("/",$request->link);
            $link_image_end = end($link_image);
            if ($link_image_end == $db_image_end) {
                unset($images[$key]);
            }
        }

        $subscription->pivot->gallery = json_encode(array_values($images));
        $subscription->pivot->save();

        return $this->successResponse(__('deleted_successfully'));
    }

    public function formatSocialLink(?string $link)
    {
        $link = (string) $link;
        $words = explode('/', $link);

        if (empty($words)) {
            return '';
        }

        return end($words);
    }
    
    
       public function storeFree(Request $request)
    {
        //Check if user has a subscription and add the old balance to new subscription
        $oldSubscription = auth()->user()->subscription()->first();
        $user = auth()->user();
        $subscription = Subscription::find($request->subscription_id);
        $price=$subscription->price;
        $coupon = $request->coupon;
        $marketer=null;
        if ($coupon) {
            $marketer = Marketer::where('code', $coupon)->whereJsonContains('subscription_ids', (string) $subscription->id)
                ->first();
            if ($marketer) {
                $price = $marketer->new_price($price);
            } else {
                $coupon = Coupon::findByCode($coupon , $subscription->id);
                if ($coupon) {
                    $price = $coupon->new_price($price);
                }
            }
        }
        if($price > 0){
            return $this->failedResponse(__('This ad is not free. Please make a payment to proceed'));
        }
        if(auth()->user()->subscription()->where('subscription_id',$subscription->id)->first()){
            return $this->failedResponse(__('You are already subscribed to this package'));
        }
        $subscriptionData['regular_ads'] = $subscription->regular_ads + (int) $oldSubscription?->pivot?->regular_ads;
        $subscriptionData['special_ads'] = $subscription->special_ads + (int) $oldSubscription?->pivot?->special_ads;
        $subscriptionData['end_date'] = Carbon::now()->addDays($subscription->duration);
        $subscriptionData['coupon'] = '';
        $subscriptionData['price'] = 0;
        $subscriptionData['is_active'] = 1;
        $subscriptionData['payment_id'] =null;
        auth()->user()->subscription()->sync([$subscription->id => $subscriptionData]);
          if($marketer){
              MarketerTransaction::create([
                  'user_id'=>auth()->user()->id,
                  'marketer_id'=>$marketer->id,
                  'subscription_id'=>$subscription->id,
                  'payment_id'=>null,
                  'amount'=>0
                  ]);
          }
        return $this->successResponse(__('subscribe_successfully'));
    }

}
