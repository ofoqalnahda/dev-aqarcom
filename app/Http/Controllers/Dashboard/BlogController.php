<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::get();

        return view('dashboard.blogs.index' , compact('blogs'));
    }


    public function create()
    {
        return view('dashboard.blogs.create');
    }

    public function store(BlogRequest $request)
    {
        $blogData = $request->validated();

        $blogData['image'] = image_uploader_with_resize($request->image,'blogs',300 , 300);

        Blog::create($blogData);

        return to_route('dashboard.blogs.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Blog $blog)
    {
        return view('dashboard.blogs.edit' , compact('blog'));
    }


    public function update(BlogRequest $request, Blog $blog)
    {
        $blogData = $request->safe()->except(['image']);

        if ($request->has('image'))
            $blogData['image'] = image_uploader_with_resize($request->image,'blogs',300 , 300);

        $blog->update($blogData);

        return to_route('dashboard.blogs.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return to_route('dashboard.blogs.index')->with(['success'=>__('deleted_successfully')]);
    }
}
