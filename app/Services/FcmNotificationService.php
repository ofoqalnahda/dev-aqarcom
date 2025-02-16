<?php
namespace App\Services;

use App\Models\Chat;
use App\Models\User;

class FcmNotificationService
{
    private ?User $user;
    private ?Chat $chat;
    public  ?string $title;
    public  ?string $body;

    public function __construct(?User $user , ?Chat $chat = null)
    {
        $this->chat = $chat;
        $this->user = $user;
    }

    public function sendSingleNotification():void {
        $token = env('FCM_TOKEN' , "AAAA2WYk5bE:APA91bEa7WvKhbvt9OKquUGosDnAKCs4oxEeK_nGnUyQw0RhDt0dxh3rnSylF9JL5rued2WONefcxuY5_hnQfS4zzNeyCSHGBle1mjIf0fjRa0XcTGKrsxG7vsn1YuzuSo7CN2OiOpXb");



        if(!$this->user->receive_notification)
            return;



        $fields = array (
            'to' => $this->user->device_token,
            'notification' => $this->getNotificationBody(),
            'data' => array (
                "chat_id"   => $this->chat->id,
                "avatar"    => get_file(auth()->user()?->image),
                "name"      => auth()->user()?->name,
            )
        );
        $fields = json_encode ( $fields );
        $headers = array (
            'Authorization:key=' . $token,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $response = curl_exec($ch);

    }
    public static function sendGroupNotification($ids , $messageData):void {
        $token = env('FCM_TOKEN' , "AAAA2WYk5bE:APA91bEa7WvKhbvt9OKquUGosDnAKCs4oxEeK_nGnUyQw0RhDt0dxh3rnSylF9JL5rued2WONefcxuY5_hnQfS4zzNeyCSHGBle1mjIf0fjRa0XcTGKrsxG7vsn1YuzuSo7CN2OiOpXb");

        $fields = array (
            'registration_ids' => $ids,
            'notification' =>[
                'title' => $messageData['title'],
                'body'  => $messageData['message']
            ]
        );
        $fields = json_encode ( $fields );
        $headers = array (
            'Authorization:key=' . $token,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $response = curl_exec($ch);

    }
    private function getNotificationBody(){
        if(!is_null($this->chat)){
            return [
                'title' => $this->chat->title??__('new_message'),
                'body'  => __('new_message_from') . auth('api')->user()?->name ?? ' عقاركوم',
            ];
        }

        return [
            'title' => $this->title,
            'body'  => $this->body
        ];
    }
}
