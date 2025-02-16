<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaymentService {

    static function createBankPayment(string $receipt)
    {
        $payment = Payment::create([
            'type' =>'bank',
            'receipt' => $receipt
        ]);
        return $payment->id;
    }

    static function createOnlinePayment(string $payment_id, string $type = 'online' )
    {
        $payment = Payment::create([
            'type' =>$type,
            'moyassar_payment_id' => $payment_id
        ]);
        return $payment->id;
    }


    public static function getPayment(string $id){

        // $response = Http::withBasicAuth('sk_test_RVGcLX2deU7jdECN6Mec7Cn47GN9EzYdxQ7RXgtP', '')->get('https://api.moyasar.com/v1/payments/'.$id);

        $response = Http::withBasicAuth('sk_live_TpBxe9HBfB1dyTVaVFoDjVYLX7S4WGRM9GkhmkNE', '')->get('https://api.moyasar.com/v1/payments/'.$id);
        return $response->json();
    }




}
