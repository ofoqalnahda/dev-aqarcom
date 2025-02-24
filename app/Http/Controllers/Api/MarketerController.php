<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreWithdrawalRequest;
use App\Http\Resources\MarketerResource;
use App\Http\Resources\MarketerTransactionResource;
use App\Http\Resources\MarketerUsersResource;
use App\Models\Draw;
use App\Models\Marketer;
use App\Models\MarketerTransaction;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Predis\Command\Traits\DB;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\DB as FaDB;

class MarketerController extends Controller
{
    use ResponseTrait;
    public function getProfile()
    {
        $Marketer=Marketer::with('user:id,name','draws')
            ->where('user_id', auth()->id())
            ->select([
                'marketers.*',
                \DB::raw("(SELECT COUNT(*) FROM marketer_transactions WHERE marketer_transactions.marketer_id = marketers.id) AS transactions_count"),
                \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'pending') AS total_deposits_pending"),
                \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'completed') AS total_deposits"),
                \DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'withdraw' AND status = 'completed') AS total_withdrawals"),
                \DB::raw("( 
                    (SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'deposit' AND status = 'completed') 
                    - 
                    (SELECT COALESCE(SUM(amount), 0) FROM draws WHERE draws.marketer_id = marketers.id AND transaction_type = 'withdraw' AND status = 'completed')
                ) AS balance")
            ])
            ->first();
        if(!$Marketer){
            return $this->failedResponse(__('Marketer_Fail'));
        }
        return $this->successResponse(data:MarketerResource::make($Marketer));
    }
    public function getTransactions(Request $request)
    {
        $Marketer=Marketer::where('user_id', auth()->id())
            ->first();
        if(!$Marketer){
            return $this->failedResponse(__('Marketer_Fail'));
        }

        $draws= Draw::where('marketer_id', $Marketer->id)
            ->when($request->type != 'all', function ($q) use ($request) {
                $q->where('transaction_type',$request->type);
            })->Show()->orderBy('updated_at', 'desc')
            ->simplePaginate(15);

        return $this->successResponse(data:MarketerTransactionResource::collection($draws));
    }
    public function getUsers(Request $request)
    {
        $Marketer=Marketer::where('user_id', auth()->id())
            ->first();
        if(!$Marketer){
            return $this->failedResponse(__('Marketer_Fail'));
        }

        $users = MarketerTransaction::with('user:id,name,phone')
            ->where('marketer_id', $Marketer->id)
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', function ($qUser) use ($request) {
                    $qUser->where('users.name', 'LIKE', $request->search . '%');
                });
            })
            ->orderBy('updated_at', 'desc')
            ->Paginate(10);

        $data = [
            'users' => MarketerUsersResource::collection($users),
            'perPage' => $users->perPage(),
            'currentPage' => $users->currentPage(),
            'lastPage' => $users->lastPage(),
        ];



        return $this->successResponse(data:$data);
    }


    public function StoreWithdrawal(StoreWithdrawalRequest $request)
    {
        $user=auth()->user();

        $Marketer=Marketer::with('user:id,name','draws')
            ->where('user_id', $user->id)
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
            return $this->failedResponse(__('Marketer_Fail'));
        }


        if($Marketer->balance < 500){
            return $this->failedResponse(__('Marketer_Fail_balance_min', ['amount' => 500]));
        }elseif ($request->amount > $Marketer->balance){
            return $this->failedResponse(__('Marketer_Fail_balance', ['amount' => $Marketer->balance]));
        }


           $old= Draw::where('marketer_id', $Marketer->id)
                ->where('transaction_type', 'withdraw')
                ->where('status', 'pending')
                ->first();


        if($old){
            return $this->failedResponse(__('have_old_Marketer_Fail_balance', ['amount' => $old->amount]));
        }

        FaDB::beginTransaction();
        try {

            Draw::Create([
                'marketer_id' => $Marketer->id,
                'amount' => $request->amount,
                'status' => 'pending',
                'name' => $request->name,
                'account_number' => $request->account_number,
                'transaction_type' => 'withdraw',
            ]);
            FaDB::commit();
            return $this->successResponse(message:__('Store_Withdrawal_Request_Success'));
        }catch (\Exception $e){
            FaDB::rollBack();
            return $this->failedResponse(__('some_error'));
        }




    }

}
