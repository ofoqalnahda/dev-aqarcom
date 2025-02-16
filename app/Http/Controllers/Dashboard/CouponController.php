<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CouponRequest;
use App\Models\Coupon;
use App\Models\Subscription;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::get();
        return view("dashboard.coupons.index", compact("coupons"));
    }

    public function create()
    {
        $subscriptions = Subscription::get();
        return view("dashboard.coupons.create", compact("subscriptions"));
    }

    public function store(CouponRequest $request)
    {
        if($request->type =="percent" && $request->value > 100)
            return back()->withErrors(["value"=>__("percent_value_error")]);
        Coupon::create($request->validated());
        return redirect()->route("dashboard.coupons.index");
    }

    public function edit(Coupon $coupon)
    {
        $subscriptions = Subscription::get();

        return view("dashboard.coupons.edit" , compact("coupon" , "subscriptions"));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return redirect()->route("dashboard.coupons.index")->with("success", __("updated_successfully"));
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route("dashboard.coupons.index")->with("success", __("deleted_successfully"));
    }


    public function toggle(Coupon $coupon)
    {
        $coupon->toggle();
        return redirect()->route("dashboard.coupons.index")->with("success", __("updated_successfully"));
    }

}
