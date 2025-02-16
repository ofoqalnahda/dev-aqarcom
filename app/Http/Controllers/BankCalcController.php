<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankCalcRequest;
use App\Http\Requests\UpdateBankCalcRequest;
use App\Jobs\BankCalculationJob;
use App\Models\BankCalc;
use App\Traits\ResponseTrait;

class BankCalcController extends Controller
{
    use ResponseTrait;

    public function index()
    {
//        dd(request()->expectsJson());
        if(request()->expectsJson()){
            $calcs = auth('api')->user()->bankCalcs;
            return $this->successResponse('' , $calcs);
        }

        $calcs = BankCalc::all();
        return view('dashboard.BankCalcs.index' , compact('calcs'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBankCalcRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBankCalcRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $calc = BankCalc::create($data);
        return $this->successResponse(__('added_successfully') , $calc);
    }

    public function show(BankCalc $bankCalc)
    {
        return view('dashboard.BankCalcs.show' , compact('bankCalc'));
    }


    public function edit(BankCalc $bankCalc)
    {
        return view('dashboard.BankCalcs.edit' , compact('bankCalc'));
    }


    public function update(UpdateBankCalcRequest $request, BankCalc $bankCalc)
    {
        $bankCalc->result = $request->result;
        $bankCalc->email_sent = false;
        $bankCalc->save();
        try{
        BankCalculationJob::dispatchSync($bankCalc);
        }catch (\Exception $e){
            return back()->withErrors(__('email_not_sent'));
        }
        return redirect()->route('dashboard.bankCalcs.index')->with('success' , __('updated_successfully'));
    }

    public function resend(BankCalc $bankCalc)
    {
        try{
            BankCalculationJob::dispatchSync($bankCalc);
        }catch (\Exception $e){
            return back()->withErrors(__('email_not_sent'));
        }

        return back()->with('success' , __('email_sent_successfully'));
    }

    public function jobs()
    {
        return  $this->successResponse("",[

                'types' =>BankCalc::jobTypes(),
                'عسكري'=>BankCalc::militaryJobTypes()


        ]);

    }

}
