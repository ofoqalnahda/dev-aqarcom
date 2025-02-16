<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function edit()
    {
        $sections = Section::with('images')->get();

        return view('dashboard.sections.edit' , compact('sections'));
    }

    public function update(Request $request , Section $section)
    {
        $request->validate([
            'images' => ['required'],
        ]);

        $section->images()->delete();

        foreach ($request->images as $image){
            $section->images()->create([
                'image' => image_uploader_without_resize($image)
            ]);
        }
        return to_route('dashboard.sections.edit')->with('success' , __('added_successfully'));
    }
}
