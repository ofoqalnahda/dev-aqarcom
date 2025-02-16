<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EstateTypeRequest;
use App\Models\EstateType;
use Illuminate\Http\Request;

class EstateTypeController extends Controller
{
    public function index(Request $request)
    {
        $estateTypes = EstateType::get();

        return view('dashboard.estateTypes.index' , compact('estateTypes'));
    }


    public function create()
    {
        return view('dashboard.estateTypes.create');
    }

    public function store(EstateTypeRequest $request)
    {
        $estateTypeData = $request->validated();
        EstateType::create($estateTypeData);
        return to_route('dashboard.estateTypes.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(EstateType $estateType)
    {
        return view('dashboard.estateTypes.edit' , compact('estateType'));
    }


    public function update(EstateTypeRequest $request, EstateType $estateType)
    {
        $estateTypeData = $request->validated();
        $estateType->update($estateTypeData);

        return to_route('dashboard.estateTypes.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(EstateType $estateType)
    {
        $estateType->delete();
        return to_route('dashboard.estateTypes.index')->with(['success'=>__('deleted_successfully')]);
    }
}
