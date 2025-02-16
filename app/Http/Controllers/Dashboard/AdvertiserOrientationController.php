<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdvertiserOrientationRequest;
use App\Models\AdvertiserOrientation;
use Illuminate\Http\Request;

class AdvertiserOrientationController extends Controller
{
    public function index(Request $request)
    {
        $advertiserOrientations = AdvertiserOrientation::get();

        return view('dashboard.advertiserOrientations.index' , compact('advertiserOrientations'));
    }


    public function create()
    {
        return view('dashboard.advertiserOrientations.create');
    }

    public function store(AdvertiserOrientationRequest $request)
    {
        $advertiserOrientationData = $request->validated();
        AdvertiserOrientation::create($advertiserOrientationData);
        return to_route('dashboard.advertiserOrientations.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(AdvertiserOrientation $advertiserOrientation)
    {
        return view('dashboard.advertiserOrientations.edit' , compact('advertiserOrientation'));
    }


    public function update(AdvertiserOrientationRequest $request, AdvertiserOrientation $advertiserOrientation)
    {
        $advertiserOrientationData = $request->validated();
        $advertiserOrientation->update($advertiserOrientationData);

        return to_route('dashboard.advertiserOrientations.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(AdvertiserOrientation $advertiserOrientation)
    {
        $advertiserOrientation->delete();
        return to_route('dashboard.advertiserOrientations.index')->with(['success'=>__('deleted_successfully')]);
    }
}
