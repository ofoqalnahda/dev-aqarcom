<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PrePurchaseServicesRequest;
use App\Models\PrePurchaseService;
use Illuminate\Http\Request;

class PrePurchaseServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = PrePurchaseService::get();

        return view('dashboard.prePurchaseServices.index' , compact('services'));
    }


    public function create()
    {
        return view('dashboard.prePurchaseServices.create');
    }

    public function store(PrePurchaseServicesRequest $request)
    {
        $serviceData = $request->validated();
        $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        PrePurchaseService::create($serviceData);
        return to_route('dashboard.prePurchaseServices.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(PrePurchaseService $service)
    {
        return view('dashboard.prePurchaseServices.edit' , compact('service'));
    }


    public function update(PrePurchaseServicesRequest $request, PrePurchaseService $service)
    {
        $serviceData = $request->safe()->except(['image']);

        if($request->has('image'))
            $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        $service->update($serviceData);

        return to_route('dashboard.prePurchaseServices.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(PrePurchaseService $service)
    {
        $service->delete();
        return to_route('dashboard.prePurchaseServices.index')->with(['success'=>__('deleted_successfully')]);
    }
}
