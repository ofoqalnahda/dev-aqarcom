<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GzipEncodeResponse
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

        $response = $next($request);
//        dd(env('GZIP_ENABLED',false)
//            , $response->isSuccessful()
//            , function_exists('gzencode')
//            , in_array('gzip', $request->getEncodings()));
        if (
            env('GZIP_ENABLED',false)
//            && $response->isSuccessful()
            && function_exists('gzencode')
//            && in_array('gzip', $request->getEncodings())
        ) {
            $response->setContent(gzencode($response->getContent(),env('COMPRESS_LEVEL',5)));
            $response->header('Content-Encoding', 'gzip');
            $response->header('Content-Length', strlen($response->getContent()));
        }
        return $response;
    }
}
