<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;

class CheckUserBalance
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $subscription = auth()->user()->subscription()->wherePivot('is_active', 1)->first();

        if ($subscription) {
            if (auth()->user()->free_ads == 0 && $subscription->pivot->regular_ads == 0 && $subscription->pivot->special_ads == 0) {
                $this->failedResponse(__('no_balance'));
            }
        } else {
            if (auth()->user()->free_ads == 0) {
                $this->failedResponse(__('no_balance'));
            }
        }
        return $next($request);
    }
}
