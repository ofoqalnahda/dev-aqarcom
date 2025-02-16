<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PostPurchaseServicesRequest;
use App\Models\PostPurchaseService;
use Illuminate\Http\Request;

class PostPurchaseServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = PostPurchaseService::get();

        return view('dashboard.postPurchaseServices.index' , compact('services'));
    }


    public function create()
    {
        return view('dashboard.postPurchaseServices.create');
    }

    public function store(PostPurchaseServicesRequest $request)
    {
        $serviceData = $request->validated();
        $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        PostPurchaseService::create($serviceData);
        return to_route('dashboard.postPurchaseServices.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(PostPurchaseService $service)
    {
        return view('dashboard.postPurchaseServices.edit' , compact('service'));
    }


    public function update(PostPurchaseServicesRequest $request, PostPurchaseService $service)
    {
        $serviceData = $request->safe()->except(['image']);

        if($request->has('image'))
            $serviceData['image'] = image_uploader_without_resize($request->image,'services');

        $service->update($serviceData);

        return to_route('dashboard.postPurchaseServices.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(PostPurchaseService $service)
    {
        $service->delete();
        return to_route('dashboard.postPurchaseServices.index')->with(['success'=>__('deleted_successfully')]);
    }
}
