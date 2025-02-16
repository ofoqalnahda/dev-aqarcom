<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BankAccountRequest;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        $bankAccounts = BankAccount::get();

        return view('dashboard.bankAccounts.index' , compact('bankAccounts'));
    }


    public function create()
    {
        return view('dashboard.bankAccounts.create');
    }

    public function store(BankAccountRequest $request)
    {
        $bankAccountData = $request->validated();
        $bankAccountData['image'] = image_uploader_with_resize($request->image,'bankAccounts',300 , 300);

        bankAccount::create($bankAccountData);
        return to_route('dashboard.bankAccounts.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('dashboard.bankAccounts.edit' , compact('bankAccount'));
    }


    public function update(BankAccountRequest $request, BankAccount $bankAccount)
    {
        $bankAccountData = $request->safe()->except(['image']);

        if($request->has('image'))
            $bankAccountData['image'] = image_uploader_with_resize($request->image,'bankAccounts',300 , 300);

        $bankAccount->update($bankAccountData);

        return to_route('dashboard.bankAccounts.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return to_route('dashboard.bankAccounts.index')->with(['success'=>__('deleted_successfully')]);
    }
}
