<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServiceRequest;
use App\Jobs\SendMessageFromAdmin;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\FCMNotificationTrait;
use App\Models\Chat;

class NotificationController extends Controller
{
    use FCMNotificationTrait;
     static function getTypes()
     {
         return [
             "all" => __("all_users"),
             "all_subscribers" => __("all_subscribers"),
             "premium_subscribers" => __("premium_subscribers"),
             "not_premium_subscribers" => __("not_premium_subscribers"),
             "not_subscribers" => __("not_subscribers"),
             "expire_soon_subscribers" => __("expire_soon_subscribers")
         ];
     }
    public function index(Request $request)
    {
        $notifications = Notification::latest()->get();
        // Notification::where('is_read' , 0)->update([
        //     'is_read' =>1
        // ]);

        return view('dashboard.notifications.index' , compact('notifications'));
    }

    public function sendForm(){
        return view('dashboard.notifications.send',['types' => self::getTypes()]);
    }

    
    public function send(Request $request){
        $messageData = $request->validate([
            'message'  => ['required'],
            "to" => ['required_if:user_id,==,null' , Rule::in(array_keys(self::getTypes()))]
        ]);
        
        
        if($request->user_id){
            $user=User::where('id',$request->user_id)->first();
            $admin = User::where('phone' , '0543442066')->first();

            if($user){
                $chat =$this->CreateMessage($admin->id,$user->id,$messageData['message']);
                $token=$user->device_token;

                if($token){
                     $data_notify=[
                        'title' => 'رسالة جديدة',
                        'message'=>$messageData['message'],
                    ];
                    $this->sendFCMNotification($token,$data_notify);
                }

               
            }
        }else{
            $sendMessagesJob = new SendMessageFromAdmin(message:$messageData['message'],to:$messageData['to']);
            $this->dispatch($sendMessagesJob);
        }
       

        return back()->with('success' , __('sent_successfully'));
    }
     public function show($notification_id){
        $notification = Notification::where('id',$notification_id)->first();
        $notification->update([
            'is_read' =>1
        ]);
        return redirect()->to($notification->link .'?id='.$notification->type_id);
    }
    
    
    
    function CreateMessage($admin_id,$receiver_id,$message,$title=null){
        $chat = Chat::where([['user_id' , '=' , $admin_id],['receiver_id' , '=' , $receiver_id]])
                ->orWhere([['receiver_id' , '=' , $admin_id],['user_id' , '=' , $receiver_id]])->first();

            if(!$chat){
                 $chat = Chat::create([
                    'user_id'   => $admin_id,
                    'receiver_id' => $receiver_id
                ]);
                
            }
               
                
         
        $chat->messages()->create([
            'sender_id' => $admin_id,
            'message'   => $message
        ]);
    }
}
