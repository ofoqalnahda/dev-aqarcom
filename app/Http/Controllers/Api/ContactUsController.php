<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactUsRequest;
use App\Models\ContactMessage;
use App\Traits\ResponseTrait;
use App\Services\PaymentService;
use Illuminate\Http\Request;
class ContactUsController extends Controller
{
    
        use ResponseTrait;


    public function __construct()
    {
        if (request()->hasHeader('Authorization')) {
            $this->middleware('auth:api');
        }
    }
    
    
    public function store(ContactUsRequest $request)
    {
        $messageData = $request->validated();
        if(auth('api')->id()){
            $messageData['user_id']=auth('api')->id();
        }
      $Message=  ContactMessage::create($messageData);


        $message = "يوجد رسالة تواصل جديدة ,رقم المرسل : ".$messageData['phone'];

        \App\Services\AdminNotification::create($message , route('dashboard.contact.index',[],false),$Message->id);
        return $this->successResponse(__('sent_successfully'));
    }


    public function donate(Request $request){
        $request->validate([
            'amount' => ['required' , 'min:0']
        ]);
        $url = route('payment.store' , ['donation' ,'user_id' => auth('api')->id()]);

        return $this->successResponse(data:[
            'url' => route('payment.create' , [$request->amount , 'url' => $url ,'user_id' => auth('api')->id()])
        ]);
    }
}
