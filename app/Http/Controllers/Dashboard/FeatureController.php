<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FeatureRequest;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $features = Feature::get();

        return view('dashboard.features.index' , compact('features'));
    }


    public function create()
    {
        return view('dashboard.features.create');
    }

    public function store(FeatureRequest $request)
    {
        $featureData = $request->validated();
        Feature::create($featureData);
        return to_route('dashboard.features.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Feature $feature)
    {
        return view('dashboard.features.edit' , compact('feature'));
    }


    public function update(FeatureRequest $request, Feature $feature)
    {
        $featureData = $request->validated();

        $feature->update($featureData);

        return to_route('dashboard.features.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return to_route('dashboard.features.index')->with(['success'=>__('deleted_successfully')]);
    }
}
