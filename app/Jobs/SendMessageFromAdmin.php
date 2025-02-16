<?php

namespace App\Jobs;

use App\Http\Controllers\Dashboard\NotificationController;
use App\Models\Chat;
use App\Models\Setting;
use App\Models\User;
use App\Services\FcmNotificationService;
use App\Traits\FCMNotificationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Illuminate\Support\Facades\Log;

class SendMessageFromAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,FCMNotificationTrait;
    public $message ;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $message,public string $to="all",public $title=null)
    {

        $this->message = $message;
    }

    private function get_query(){
        $query = \DB::table('users')->whereNotNull('device_token');
        if($this->to == "all"){}
        elseif ($this->to == "all_subscribers")
            $query = $query->join('user_subscription' , 'user_subscription.user_id' , '=' , 'users.id')
                ->where(function ($query) {
                    // Users with no subscription or not active subscriptions
                    $query->whereNotNull('user_subscription.id')
                        ->where('user_subscription.is_active' , 1)
                        ->whereDate('user_subscription.end_date', '>', now());
                });

        elseif ($this->to == "premium_subscribers")
            $query = $query->join('user_subscription' , 'user_subscription.user_id' , '=' , 'users.id')
                ->join('subscriptions','subscriptions.id','=','user_subscription.subscription_id')
                ->where(function ($query) {
                    // Users with no subscription or not active subscriptions
                    $query->whereNotNull('user_subscription.id')
                        ->where('user_subscription.is_active' , 1)
                        ->where('subscriptions.premium' , 1)
                        ->whereDate('user_subscription.end_date', '>', now());
                });
        elseif ($this->to == "not_premium_subscribers")
            $query = $query->join('user_subscription' , 'user_subscription.user_id' , '=' , 'users.id')
                ->join('subscriptions','subscriptions.id','=','user_subscription.subscription_id')
                ->where(function ($query) {
                    // Users with no subscription or not active subscriptions
                    $query->whereNotNull('user_subscription.id')
                        ->where('user_subscription.is_active' , 1)
                        ->where('subscriptions.premium' , 0)
                        ->whereDate('user_subscription.end_date', '>', now());
                });
        elseif ($this->to == "not_subscribers")
            $query = $query->leftJoin('user_subscription' , 'user_subscription.user_id' , '=' , 'users.id')
                ->where(function ($query) {
                    // Users with no subscription or not active subscriptions
                    $query->orWhereNull('user_subscription.id')
                        ->orWhere('user_subscription.is_active' , 0)
                        ->orWhereDate('user_subscription.end_date', '<', now());
                });
        elseif ($this->to == "expire_soon_subscribers")
            $query = $query->join('user_subscription' , 'user_subscription.user_id' , '=' , 'users.id')
                ->where(function ($query) {
                    // Users with no subscription or not active subscriptions
                    $query->whereNotNull('user_subscription.id')
                        ->where('user_subscription.is_active' , 1)
                        ->whereDate('user_subscription.end_date', '>', now())
                        ->whereDate('user_subscription.end_date', '<', now()->addDays(env('expire_soon_days' , 15)));
                });
        return $query;
    }

    public function handle()
    {
      $admin = User::where('phone' , '0543442066')->first();
      $tokens = [];
      if(!$admin || !in_array($this->to, array_keys(NotificationController::getTypes())))
            return;
      // I have 3 tables users user
        $query = $this->get_query();
        
        $query->select("users.id")->orderBy("users.id","asc")->chunk(/**
         * @throws MessagingException
         * @throws FirebaseException
         */ 100, function($users) use($admin,&$tokens){
            foreach ($users as $receiver){
                if($admin->id == $receiver->id)continue;
                if (!$this->title){
                    $chat = Chat::where([['user_id' , '=' , $admin->id],['receiver_id' , '=' , $receiver->id]])
                        ->orWhere([['receiver_id' , '=' , $admin->id],['user_id' , '=' , $receiver->id]])->first();

                    if(!$chat)
                        $chat = Chat::create([
                            'user_id'   => $admin->id,
                            'receiver_id' => $receiver->id
                        ]);

                }
                else{
                    $chat = Chat::create([
                        'user_id'   => $admin->id,
                        'receiver_id' => $receiver->id,
                        'title' => $this->title,
                    ]);
                }
                $chat->messages()->create([
                    'sender_id' => $admin->id,
                    'message'   => $this->message
                ]);
                 
                /* -------------------------------------- */
//                $tokens[] = $chat->receiver->device_token;
                    
                   $tokens[] =  $chat->receiver->device_token;
                /* -------------------------------------- */
                $messageData = [
                    'title' => 'رسالة جديدة',
                    'message'  => $this->message,//'لديك رسالة جديدة من المسؤول',
                ];
                
            }
            /* -------------------------------------- */
                $this->sendMultiFCMNotification( $tokens , $messageData);
//            FcmNotificationService::sendGroupNotification($tokens ,$messageData);
                $tokens = [];
//            $tokens = [];
            /* -------------------------------------- */


        });

    }
}
