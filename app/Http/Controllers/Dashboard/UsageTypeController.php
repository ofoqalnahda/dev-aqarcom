<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UsageTypeRequest;
use App\Models\UsageType;
use Illuminate\Http\Request;

class UsageTypeController extends Controller
{
    public function index(Request $request)
    {
        $usageTypes = UsageType::get();

        return view('dashboard.usageTypes.index' , compact('usageTypes'));
    }


    public function create()
    {
        return view('dashboard.usageTypes.create');
    }

    public function store(UsageTypeRequest $request)
    {
        $usageTypeData = $request->validated();
        UsageType::create($usageTypeData);
        return to_route('dashboard.usageTypes.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(UsageType $usageType)
    {
        return view('dashboard.usageTypes.edit' , compact('usageType'));
    }


    public function update(UsageTypeRequest $request, UsageType $usageType)
    {
        $usageTypeData = $request->validated();
        $usageType->update($usageTypeData);

        return to_route('dashboard.usageTypes.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(UsageType $usageType)
    {
        $usageType->delete();
        return to_route('dashboard.usageTypes.index')->with(['success'=>__('deleted_successfully')]);
    }
}
