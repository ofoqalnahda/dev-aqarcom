<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::latest()->when($request->id,function($q) use($request){
            $q->where('id',$request->id);
        })->get();
        return view('dashboard.contact.index' , compact('messages'));
    }
}
