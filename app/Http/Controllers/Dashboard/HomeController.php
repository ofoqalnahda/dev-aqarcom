<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:home');
    }
    public function index()
    {
        //$sellAds = Ad::withOutGlobarScopes()->where()->get();
        return view('dashboard.home');
    }
}
