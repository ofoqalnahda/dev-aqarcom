<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PropertyRequest;
use App\Models\AdType;
use App\Models\EstateType;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::get();

        return view('dashboard.properties.index' , compact('properties'));
    }


    public function create()
    {
        $estateTypes = EstateType::all();
        $adTypes = AdType::all();
        return view('dashboard.properties.create' , compact('estateTypes' , 'adTypes'));
    }

    public function store(PropertyRequest $request)
    {
        $propertyData = $request->safe()->except(['min_value' , 'max_value' , 'values' , 'images']);
        $propertyData['show_outside'] = $request->show_outside ? 1 : 0;

        if($request->type == 'slider'){
            $propertyData['min_value'] = $request->min_value;
            $propertyData['max_value'] = $request->max_value;
        }else if($request->type == 'multi'){
            $propertyData['values_ar'] = json_encode($request->values['ar']);
            $propertyData['values_en'] = json_encode($request->values['en']);
        }

        $propertyData['image'] = image_uploader_without_resize($request->image , 'properties');

        Property::create($propertyData);
        return to_route('dashboard.properties.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Property $property)
    {
        $estateTypes = EstateType::all();
        $adTypes = AdType::all();
        return view('dashboard.properties.edit' , compact(['property' , 'estateTypes' , 'adTypes']));
    }


    public function update(PropertyRequest $request, Property $property)
    {
        $propertyData = $request->safe()->except(['min_value' , 'max_value' , 'values' , 'images']);
        $propertyData['show_outside'] = $request->show_outside ? 1 : 0;

        if($request->type == 'slider'){
            $propertyData['min_value'] = $request->min_value;
            $propertyData['max_value'] = $request->max_value;
        }else if($request->type == 'multi'){
            $propertyData['values_ar'] = json_encode($request->values['ar']);
            $propertyData['values_en'] = json_encode($request->values['en']);
        }

        if($request->image)
            $propertyData['image'] = image_uploader_without_resize($request->image , 'properties');

        $property->update($propertyData);
        return to_route('dashboard.properties.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return to_route('dashboard.properties.index')->with(['success'=>__('deleted_successfully')]);
    }
}
