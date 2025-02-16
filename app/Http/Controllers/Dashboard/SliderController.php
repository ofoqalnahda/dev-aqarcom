<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function index()
    {
        $sliders = Slider::get();
//        dd($sliders[0]->image);
        return view('dashboard.sliders.index' , compact('sliders'));
    }


    public function store(Request $request)
    {
        $image = $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg'
        ]);
        $image['image'] = image_uploader_with_resize($image['image'] , 'sliders',300 , 300);
        Slider::create($image);

        return to_route('dashboard.sliders.index')->with(['success'=>__('created_successfully')]);
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return to_route('dashboard.sliders.index')->with(['success'=>__('deleted_successfully')]);

    }
}
