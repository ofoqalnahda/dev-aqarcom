<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ReportReasonRequest;
use App\Models\ReportReason;
use Illuminate\Http\Request;

class ReportReasonController extends Controller
{
    public function index(Request $request)
    {
        $reportReasons = ReportReason::get();

        return view('dashboard.reportReasons.index' , compact('reportReasons'));
    }


    public function create()
    {
        return view('dashboard.reportReasons.create');
    }

    public function store(ReportReasonRequest $request)
    {
        $reportReasonData = $request->validated();
        ReportReason::create($reportReasonData);
        return to_route('dashboard.reportReasons.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(ReportReason $reportReason)
    {
        return view('dashboard.reportReasons.edit' , compact('reportReason'));
    }


    public function update(ReportReasonRequest $request, ReportReason $reportReason)
    {
        $reportReasonData = $request->validated();
        $reportReason->update($reportReasonData);

        return to_route('dashboard.reportReasons.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(ReportReason $reportReason)
    {
        $reportReason->delete();
        return to_route('dashboard.reportReasons.index')->with(['success'=>__('deleted_successfully')]);
    }
}
