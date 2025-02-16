<?php

namespace App\Services;

use App\Models\Notification;

class AdminNotification{
    public static function create(string $message ,string  $link,int $type_id = null) :void{
        Notification::create([
            'message' => $message,
            'type_id' => $type_id,
            'link'    => $link
        ]);
    }
}
