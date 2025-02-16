<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait ResponseTrait {
    function successResponse($message = '' ,$data = [] , $status = 200,$extra=[] ) : JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
            ...$extra
        ] , $status);
    }

    function failedResponse($message , $status = 422 ) : JsonResponse
    {
        return response()->json([
            'success'   => false,
            'message'   => $message,
        ] , $status);
    }
     function failedWithDataResponse($message ,$data= [], $status = 422 ) : JsonResponse
    {
        return response()->json([
            'success'   => false,
            'data'   => $data,
            'message'   => $message,
        ] , $status);
    }
}
