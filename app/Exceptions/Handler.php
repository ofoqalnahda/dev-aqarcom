<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            $request->headers->set('Accept', 'application/json');
        }


        if($e instanceof HttpResponseException){
            return $e->getResponse();
        }

        if ($request->expectsJson() && $e instanceof ValidationException) {
            throw new HttpResponseException($this->failedResponse($e->validator->errors()->first()));
        } elseif ($request->expectsJson() && $e instanceof ModelNotFoundException) {
            throw new HttpResponseException($this->failedResponse($e->getMessage()));
        } elseif (
            !$request->expectsJson() // Not an ajax request
            && $e instanceof NotFoundHttpException // Route not found
            && !($request->is('api/*') || $request->is('dashboard/*'))) // Not an api or dashboard request
        {
            return redirect()->route('home');

        }


        elseif ($request->expectsJson()) {
            $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], $status);
        }


        return parent::render($request, $e);
    }

    public function report(Throwable $exception): void
    {
//        if ($this->shouldReport($exception)) {
        \Log::channel('exceptions_log')->error('Exception logged', [
            'message' => $exception->getMessage(),
            'url' => request()->fullUrl(),
            'request_data' => request()->except($this->dontFlash),
            'stack_trace' => $exception->getTraceAsString(),
        ]);
//        }

        parent::report($exception);
    }
}
