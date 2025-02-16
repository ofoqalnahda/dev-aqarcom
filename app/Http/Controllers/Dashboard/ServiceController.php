<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::orderBy('sort')->get();
        return view('dashboard.services.index' , compact('services'));
    }


    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $serviceData = $request->validated();
        $serviceData['image'] = image_uploader_without_resize($request->image,'services');
//        dd($serviceData);
        Service::create($serviceData);

        return to_route('dashboard.services.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Service $service)
    {
        return view('dashboard.services.edit' , compact('service'));
    }


    public function update(ServiceRequest $request, Service $service)
    {
        $serviceData = $request->safe()->except(['image']);

        if($request->has('image'))
            $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        $service->update($serviceData);

        return to_route('dashboard.services.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(Service $service)
    {
        $service->delete();
//        return to_route('dashboard.services.index')->with(['success'=>__('deleted_successfully')]);
        return back()->with(['success'=>__('deleted_successfully')]);
    }
}
