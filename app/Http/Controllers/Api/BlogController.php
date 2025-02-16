<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $blogs  = server_cache(class_basename(Blog::class),'long',fn()=>
            Blog::latest()->get()
        );
        return $this->successResponse(data:BlogResource::collection($blogs));
    }

    public function show(Blog $blog)
    {
        return $this->successResponse(data:BlogResource::make($blog));
    }
}
