<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdTypeRequest;
use App\Models\AdType;
use Illuminate\Http\Request;

class AdTypeController extends Controller
{
    public function index(Request $request)
    {
        $adTypes = AdType::get();

        return view('dashboard.adTypes.index' , compact('adTypes'));
    }


    public function create()
    {
        return view('dashboard.adTypes.create');
    }

    public function store(AdTypeRequest $request)
    {
        $adTypeData = $request->validated();
        AdType::create($adTypeData);
        return to_route('dashboard.adTypes.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(AdType $adType)
    {
        return view('dashboard.adTypes.edit' , compact('adType'));
    }


    public function update(AdTypeRequest $request, AdType $adType)
    {
        $adTypeData = $request->validated();
        $adType->update($adTypeData);

        return to_route('dashboard.adTypes.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(AdType $adType)
    {
        $adType->delete();
        return to_route('dashboard.adTypes.index')->with(['success'=>__('deleted_successfully')]);
    }

}
