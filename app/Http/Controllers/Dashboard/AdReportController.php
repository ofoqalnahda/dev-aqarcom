<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AdReport;
use Illuminate\Http\Request;

class AdReportController extends Controller
{
    public function index(Request $request)
    {
        $adReports = AdReport::when($request->id,function($q) use($request){
            $q->where('id',$request->id);
        })->latest()->get();
        return view('dashboard.adReports.index' , compact('adReports'));
    }

    public function destroy(AdReport $adReport)
    {
        $adReport->delete();
        return to_route('dashboard.adReports.index')->with(['success'=>__('deleted_successfully')]);
    }
}
