<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AccountTypeRequest;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    public function index(Request $request)
    {
        $accountTypes = AccountType::get();

        return view('dashboard.accountTypes.index' , compact('accountTypes'));
    }


    public function create()
    {
        return view('dashboard.accountTypes.create');
    }

    public function store(AccountTypeRequest $request)
    {
        $accountTypeData = $request->validated();
        AccountType::create($accountTypeData);
        return to_route('dashboard.accountTypes.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(AccountType $accountType)
    {
        return view('dashboard.accountTypes.edit' , compact('accountType'));
    }


    public function update(AccountTypeRequest $request, AccountType $accountType)
    {
        $accountTypeData = $request->validated();
        $accountType->update($accountTypeData);

        return to_route('dashboard.accountTypes.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(AccountType $accountType)
    {
        $accountType->delete();
        return to_route('dashboard.accountTypes.index')->with(['success'=>__('deleted_successfully')]);
    }
}
