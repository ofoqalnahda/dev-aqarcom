<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SupportServiceAd;
use Illuminate\Http\Request;

class SupportServiceAdsController extends Controller
{
    public function index()
    {
        $ads = SupportServiceAd::latest()->paginate(20);
        return view('dashboard.support-service-ads.index', compact('ads'));
    }

    public function show(SupportServiceAd $supportServiceAd)
    {
        return view('dashboard.support-service-ads.show', [
            'ad' => $supportServiceAd,
        ]);
    }

    public function destroy(SupportServiceAd $supportServiceAd)
    {
        $supportServiceAd->delete();
        return redirect()->back()->with('success', 'تم حذف الاعلان بنجاح');
    }

    public function toggle(SupportServiceAd $supportServiceAd)
    {
        $supportServiceAd->update([
            'active' => ! $supportServiceAd->active,
        ]);
        return response()->json(['success'=>__('changed_successfully')]);
    }
}
