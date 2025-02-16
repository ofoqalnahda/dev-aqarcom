<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

trait FCMNotificationTrait
{
    /**
     * send FCM Notification
     * @param string $token
     * @param string $type
     * @param array $data_notify
     * @param string|null $image
     * @return mixed
     * @throws FirebaseException
     * @throws MessagingException
     */
    protected function sendFCMNotification(string $token , array $data_notify, string $image=null): array
    {

    $messaging = Firebase::messaging(); 

    $notification = Notification::create($data_notify['title'], $data_notify['message']);

    if ($image) {
        $notification = $notification->withImageUrl($image);
    }

    $message = CloudMessage::new()->withNotification($notification);

    if (isset($data_notify['data'])) {
        $message = $message->withData($data_notify['data']);
    }

    try {
        $response = $messaging->sendMulticast($message, [$token]);
         Log::info('FCM Multi Notification Sent Successfully', [
            'success_count' => $response->successes()->count(),
            'failure_count' => $response->failures()->count(),
        ]);
        return [
            'success' => true,
            'success_count' => $response->successes()->count(),
            'failure_count' => $response->failures()->count(),
            'failures' => $response->failures()->map(fn ($failure) => $failure->error()->getMessage()),
        ];
    } catch (\Exception $e) {
         Log::info('FCM Multi Notification Failed', [
            'error' => $e->getMessage(),
        ]);
        return [
            'success' => false,
            'error' => $e->getMessage(),
        ];
    }
    }
    
    
    
/**
 * Send Multi FCM Notifications to Multiple Tokens
 * @param array $tokens
 * @param array $data_notify
 * @param string|null $image
 * @return mixed
 * @throws FirebaseException
 * @throws MessagingException
 */


protected function sendMultiFCMNotification(array $tokens, array $data_notify, string $image = null): array
{
    $messaging = Firebase::messaging(); 

    $notification = Notification::create($data_notify['title'], $data_notify['message']);

    if ($image) {
        $notification = $notification->withImageUrl($image);
    }

    $message = CloudMessage::new()->withNotification($notification);

    if (isset($data_notify['data'])) {
        $message = $message->withData($data_notify['data']);
    }

    try {
        $response = $messaging->sendMulticast($message, $tokens);
         Log::info('FCM Multi Notification Sent Successfully', [
            'success_count' => $response->successes()->count(),
            'failure_count' => $response->failures()->count(),
        ]);
        return [
            'success' => true,
            'success_count' => $response->successes()->count(),
            'failure_count' => $response->failures()->count(),
            'failures' => $response->failures()->map(fn ($failure) => $failure->error()->getMessage()),
        ];
    } catch (\Exception $e) {
         Log::info('FCM Multi Notification Failed', [
            'error' => $e->getMessage(),
            'tokens' => $tokens,
        ]);
        return [
            'success' => false,
            'error' => $e->getMessage(),
        ];
    }
}



}
