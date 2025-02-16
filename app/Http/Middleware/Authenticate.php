<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    use ResponseTrait;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if ($request->routeIs('dashboard.*')){
            return route('dashboard.showLoginForm');
        }

        if (! $request->expectsJson() && !$request->is('api/*')) {
            return route('login');
        }else{
            throw new HttpResponseException(response()->json(['success' => false, 'message' => __('unauthenticated')] , 401));
        }
    }
}
