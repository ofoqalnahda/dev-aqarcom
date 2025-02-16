<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OTPController extends Controller
{
    public static function send(string $phone , string $message){
        $curl = curl_init();
        $app_id = "IVzE4GWnjz5F7zmVnGdQctCZGsbM4PDYJhniap7j";
        $app_sec = "YuoOkvTmGnrXxmkBLENechadvpGGA9mRrl4yoiIZ9XDl7EsvmpgEhf2nkHq3mEW3xrHxJhgsUmOovShc1n2ZnW8KO0cZvj4mLF9Y";
        $app_hash  = base64_encode("$app_id:$app_sec");
        $messages = [];
        $messages["messages"] = [];
        $messages["messages"][0]["text"] = $message;
        $messages["messages"][0]["numbers"][] = $phone;
        $messages["messages"][0]["sender"] = "AqarCom";

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sms.4jawaly.com/api/v1/account/area/sms/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($messages),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic '.$app_hash
            ),
        ));

        $response = curl_exec($curl);
        \Log::info('Sent Code Successfully',[$phone,$message,$response]);
        curl_close($curl);
    }
}
