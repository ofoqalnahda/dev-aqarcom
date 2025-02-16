<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogLongResponses
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

        if(!env('LOG_LONG_RESPONSES',false))
            return $next($request);

        // Start the timer
        $start = microtime(true);

        $response = $next($request);

        $end = microtime(true);

        // Calculate the duration of the request
        $duration = ($end - $start)*1000;
//        dd($duration);
        if ($duration > env('LOG_LONG_RESPONSES_TIME',500)) {
            // You can customize this log to include more information
            \Log::channel('long_response')->info('Long response time detected', [
                'method' => $request->method(),
                'route' => $request->route()->uri,
                'route_name' => $request->route()->getName(),
                'status_code' => $response->getStatusCode(),
                'authenticated' => $request->user() ? 'true' : 'false',
                'duration' => $duration,
                'url' => $request->fullUrl(),
                'request_data' => $request->except(['password', 'password_confirmation']), // Exclude sensitive data
            ]);
        }

        return $response;

    }
}
