<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sponser;
use Illuminate\Http\Request;

class SponsorsController extends Controller
{
    public function index()
    {
        $sponsors = Sponser::get();
        return view('dashboard.sponsors.index' , compact('sponsors'));
    }


    public function store(Request $request)
    {
        $image = $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg,webp'
        ]);
        $image['image'] = image_uploader_without_resize($image['image'] , 'sponsors',300 , 300);
        Sponser::create($image);

        return to_route('dashboard.sponsors.index')->with(['success'=>__('created_successfully')]);
    }

    public function destroy(Sponser $sponsor)
    {
        $sponsor->delete();
        return to_route('dashboard.sponsors.index')->with(['success'=>__('deleted_successfully')]);

    }
}
