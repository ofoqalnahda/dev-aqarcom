<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateNafathVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return auth()->user()->is_nafath_verified == 0 ?
                response()->json([
                    'message' => __("nafath_verification_required")
                ], 403)
            : $next($request);

    }
}
