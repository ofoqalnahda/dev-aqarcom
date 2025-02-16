<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EstateDeveloperServicesRequest;
use App\Models\EstateDeveloperService;
use Illuminate\Http\Request;

class EstateDeveloperServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = EstateDeveloperService::get();

        return view('dashboard.estateDeveloperServices.index' , compact('services'));
    }


    public function create()
    {
        return view('dashboard.estateDeveloperServices.create');
    }

    public function store(EstateDeveloperServicesRequest $request)
    {
        $serviceData = $request->validated();
        $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        EstateDeveloperService::create($serviceData);
        return to_route('dashboard.estateDeveloperServices.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(EstateDeveloperService $service)
    {
        return view('dashboard.estateDeveloperServices.edit' , compact('service'));
    }


    public function update(EstateDeveloperServicesRequest $request, EstateDeveloperService $service)
    {
        $serviceData = $request->safe()->except(['image']);

        if($request->has('image'))
            $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        $service->update($serviceData);

        return to_route('dashboard.estateDeveloperServices.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(EstateDeveloperService $service)
    {
        $service->delete();
        return to_route('dashboard.estateDeveloperServices.index')->with(['success'=>__('deleted_successfully')]);
    }
}
