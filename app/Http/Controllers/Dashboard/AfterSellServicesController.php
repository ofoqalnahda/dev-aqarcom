<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AfterSellServicesRequest;
use App\Models\AfterSellService;
use Illuminate\Http\Request;

class AfterSellServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = AfterSellService::get();

        return view('dashboard.afterSellServices.index' , compact('services'));
    }


    public function create()
    {
        return view('dashboard.afterSellServices.create');
    }

    public function store(AfterSellServicesRequest $request)
    {
        $serviceData = $request->validated();
        $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        AfterSellService::create($serviceData);
        return to_route('dashboard.afterSellServices.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(AfterSellService $service)
    {
        return view('dashboard.afterSellServices.edit' , compact('service'));
    }


    public function update(AfterSellServicesRequest $request, AfterSellService $service)
    {
        $serviceData = $request->safe()->except(['image']);

        if($request->has('image'))
            $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        $service->update($serviceData);

        return to_route('dashboard.afterSellServices.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(AfterSellService $service)
    {
        $service->delete();
        return to_route('dashboard.afterSellServices.index')->with(['success'=>__('deleted_successfully')]);
    }
}
