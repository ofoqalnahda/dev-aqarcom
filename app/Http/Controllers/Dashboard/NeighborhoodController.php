<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NeighborhoodRequest;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    public function index(Request $request)
    {
        $neighborhoods = Neighborhood::get();
        return view('dashboard.neighborhoods.index' , compact('neighborhoods'));
    }


    public function create()
    {
        $cities = City::all();
        return view('dashboard.neighborhoods.create' , compact('cities'));
    }

    public function store(NeighborhoodRequest $request)
    {
        $neighborhoodData = $request->validated();
        Neighborhood::create($neighborhoodData);
        return to_route('dashboard.neighborhoods.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Neighborhood $neighborhood)
    {
        $cities = City::all();
        return view('dashboard.neighborhoods.edit' , compact(['neighborhood' , 'cities']));
    }


    public function update(NeighborhoodRequest $request, Neighborhood $neighborhood)
    {
        $neighborhoodData = $request->validated();
        $neighborhood->update($neighborhoodData);

        return to_route('dashboard.neighborhoods.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(Neighborhood $neighborhood)
    {
        $neighborhood->delete();
        return to_route('dashboard.neighborhoods.index')->with(['success'=>__('deleted_successfully')]);
    }

}
