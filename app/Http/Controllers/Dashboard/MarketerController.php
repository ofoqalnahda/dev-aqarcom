<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Marketer;
use App\Models\MarketerTransaction;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserSubscription;
use App\Http\Requests\Dashboard\MarketerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\OTPController;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Transliterator;

class MarketerController extends Controller
{
    public function index(Request $request)
    {
        $marketers = Marketer::get();

        return view('dashboard.marketers.index' , compact('marketers'));
    }


    public function create()
    {
        $subscriptions = Subscription::get();
        $users = User::select('id','name','phone')->orderBy('name')->get();

        return view('dashboard.marketers.create' , compact('subscriptions','users'));
    }

    public function store(MarketerRequest $request)
    {
       
        $marketerData = $request->safe()->except(['image','subscription_commission_percentage','subscription_discount_percentage']);
        if($request->image){
                    $marketerData['image'] = image_uploader_with_resize($request->image,'marketers',300 , 300);
        }
        $marketer = Marketer::create($marketerData);
        if($request->subscription_commission_percentage){
            $data=[];
            foreach($request->subscription_commission_percentage as $id => $subscription){
                 $data[$id]=['commission_percentage'=>$subscription,
                'discount_percentage'=>$request->subscription_discount_percentage[$id]];
            } 
            $marketer->subscriptions()->sync($data);
        }
            
        return to_route('dashboard.marketers.index')->with(['success'=>'تم الإضافة بنجاح !']);
    }

    public function edit(Marketer $marketer)
    {
        $subscriptions = Subscription::get();
        $users = User::select('id','name','phone')->orderBy('name')->get();

        $oldSubscriptions=[];
        foreach($marketer->subscriptions as $subscription){
              $oldSubscriptions[$subscription->id] = [
                  'commission_percentage'=>$subscription->pivot->commission_percentage,
                  'discount_percentage'=>$subscription->pivot->discount_percentage,
                  ];
        }
        
        return view('dashboard.marketers.edit' , compact('marketer','users' , 'subscriptions','oldSubscriptions'));
    }


    public function update(MarketerRequest $request, Marketer $marketer)
    {
        $marketerData = $request->safe()->except(['image','subscription_commission_percentage','subscription_discount_percentage']);

        if($request->image)
            $marketerData['image'] = image_uploader_with_resize($request->image,'marketers',300 , 300);

        $marketer->update($marketerData);
        
         
           if($request->subscription_commission_percentage){
               $data=[];
            foreach($request->subscription_commission_percentage as $id => $subscription){
                $data[$id]=['commission_percentage'=>$subscription,
                'discount_percentage'=>$request->subscription_discount_percentage[$id]];
            } 
            $marketer->subscriptions()->sync($data);
        }

        return to_route('dashboard.marketers.index')->with(['success'=>'تم التعديل بنجاح !']);
    }

    public function draws(Marketer $marketer){
        $draws = $marketer->draws;
        $subscriptionRequests =MarketerTransaction::where('marketer_id',$marketer->id)
            ->with(['user' => function ($query) {
                $query->withCount('ads');
            }])
            ->wherehas('user')->get();
        $marketer=$marketer->select([
                'marketers.*',
                \DB::raw("(SELECT COUNT(*) FROM marketer_transactions WHERE marketer_transactions.marketer_id = marketers.id) AS transactions_count"),
                \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'pending') AS total_deposits_pending"),
                \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'completed') AS total_deposits"),
            \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'withdraw' AND status = 'pending') AS total_withdrawals_pending"),
            \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'withdraw' AND status = 'completed') AS total_withdrawals"),
                \DB::raw("( 
                    (SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'completed') 
                    - 
                    (SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'withdraw' AND status = 'completed')
                ) AS balance")
            ])
            ->first();
        return view('dashboard.marketers.draws' , compact('draws' ,'marketer', 'subscriptionRequests'));
    }

    public function clearBalance(Marketer $marketer){
        if($marketer->balance > 0){
            $marketer->draws()->create([
                'balance' => $marketer->balance,
            ]);
            $marketer->balance = 0;
            $marketer->save();
        }

        return to_route('dashboard.marketers.index')->with(['success'=>'تمت التصفية بنجاح']);
    }

    public function show(Marketer $marketer){

        return view('dashboard.marketers.show' , compact('marketer'));
    }


    public function sendCode(Marketer $marketer){
        $new_code = rand(1000 , 9999);
        $marketer->delete_code = $new_code;
        $marketer->save();

        $phone = Setting::first()?->phone;
        OTPController::send($phone ?? '0543442066' , $new_code);
        return response()->json();
    }

    public function destroy(Marketer $marketer)
    {
        if(request()->code == null || (request()->code != $marketer->delete_code))
            return response()->json([] , 422);

        $marketer->delete();
        return response()->json();
    }
    public function getCode( Request $request)
    {



        $code=null;
        if($request->name){
            $firstChar=  $this->getFirstLetter($request->name);
            $code=$this->generateCode($firstChar);
        }
        return [
            'success' => true,
            'data' => [
                'code'=>$code,
            ]
        ];
    }
    function sendMoney ($transaction_id)
    {
        $transaction = MarketerTransaction::whereId($transaction_id)->first();
        if(!$transaction){
            return redirect()->back()->with(['error'=>__('sendMoneyErrorNotFoundMessage')]);
        }
        if($transaction->is_deserved){
            return redirect()->back()->with(['error'=>__('sendMoneyErrorDeservedMessage')]);
        }
        DB::beginTransaction();
        try {
            $transaction->is_deserved=true;
            $transaction->save();
            Draw::where('transaction_id',$transaction_id)->update([
                'status' => 'completed',
            ]);
            DB::commit();
            return redirect()->back()->with(['success'=>__('sendMoneySuccessMessage')]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error'=>__('sendMoneyErrorMessage')]);
        }
    }


    function sendWithdrawMoney ($draw_id)
    {
        $draw = Draw::whereId($draw_id)->first();
        if(!$draw){
            return redirect()->back()->with(['error'=>__('sendDrawErrorNotFoundMessage')]);
        }
        if($draw->status == 'completed' ){
            return redirect()->back()->with(['error'=>__('sendDrawErrorDeservedMessage')]);
        }
        $Marketer=Marketer::with('user:id,name','draws')
            ->where('id', $draw->marketer_id)
            ->select([
                'marketers.*',

                \DB::raw("( 
                    (SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'completed') 
                    - 
                    (SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'withdraw' AND status = 'completed')
                ) AS balance")
            ])
            ->first();
        if(!$Marketer){
            return redirect()->back()->with(['error'=>__('DashMarketer_Fail')]);
        }


        if($Marketer->balance < 500){
            return redirect()->back()->with(['error'=>__('Marketer_Fail_balance_min', ['amount' => 500])]);

        }elseif ($draw->amount > $Marketer->balance){
            return redirect()->back()->with(['error'=>__('Marketer_Fail_balance', ['amount' => $Marketer->balance])]);
        }


        DB::beginTransaction();
        try {

            $draw->status = 'completed';
            $draw->save();
            DB::commit();
            return redirect()->back()->with(['success'=>__('sendDrawMoneySuccessMessage')]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error'=>__('sendMoneyErrorMessage')]);
        }
    }
    public function getData( Request $request)
    {

        if(Marketer::where('user_id',$request->user_id)->exists()){
            return [
                'success' => false,
                'text' => __('error_marketer_exits')
            ];
        }
        $user=User::whereId($request->user_id)->first();

        if(!$user){
            return [
                'success' => false,
                'text' => __('error_user_not_found')
            ];
        }

        return [
            'success' => true,
            'data' => [
                'name'=>$user->name,
                'phone'=>$user->phone,
                'email'=>$user->email,
            ]
        ];
    }
    function generateCode($Letter)
    {
        $lastCode = Marketer::where('code', 'LIKE', $Letter . '%')
            ->whereRaw("LENGTH(code) = 4")
            ->whereRaw("code REGEXP '^[A-Z][0-9]{3}$'")
            ->orderBy('code', 'desc')
            ->value('code');
        if ($lastCode) {
            $number = (int) substr($lastCode, 1) + 1;
        } else {
            $number = 1;
        }
        return $Letter . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    function getFirstLetter($name) {
        $name = Str::slug($name);
        return strtoupper(mb_substr($name, 0, 1, "UTF-8"));
    }

}
