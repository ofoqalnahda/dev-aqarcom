<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CityRequest;
use App\Models\City;
use App\Models\Area;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::get();
        return view('dashboard.cities.index' , compact('cities'));
    }

    public function create()
    {
        $areas = Area::all();
        $states = State::all();
        return view('dashboard.cities.create' , compact(['areas' , 'states']));
    }

    public function store(CityRequest $request)
    {
        $cityData = $request->validated();
        City::create($cityData);
        return to_route('dashboard.cities.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(City $city)
    {
        $areas = Area::all();
        $states = State::all();

        return view('dashboard.cities.edit' , compact(['city' , 'areas' , 'states']));
    }

    public function update(CityRequest $request, City $city)
    {
        $cityData = $request->validated();
        $city->update($cityData);

        return to_route('dashboard.cities.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return to_route('dashboard.cities.index')->with(['success'=>__('deleted_successfully')]);
    }
}
