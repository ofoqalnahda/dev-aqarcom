<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SupportServicesRequest;
use App\Models\SupportService;
use Illuminate\Http\Request;

class SupportServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = SupportService::orderBy('sort')->get();

        return view('dashboard.supportServices.index' , compact('services'));
    }


    public function create()
    {
        return view('dashboard.supportServices.create');
    }

    public function store(SupportServicesRequest $request)
    {
        $serviceData = $request->validated();
        $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        SupportService::create($serviceData);
        return to_route('dashboard.supportServices.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(SupportService $service)
    {
        return view('dashboard.supportServices.edit' , compact('service'));
    }


    public function update(SupportServicesRequest $request, SupportService $service)
    {
        $serviceData = $request->safe()->except(['image']);

        if($request->has('image'))
            $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        $service->update($serviceData);

        return to_route('dashboard.supportServices.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(SupportService $service)
    {
        $service->delete();
        return to_route('dashboard.supportServices.index')->with(['success'=>__('deleted_successfully')]);
    }
}
