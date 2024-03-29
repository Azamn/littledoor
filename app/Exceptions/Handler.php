<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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
    public function register(): void
    {
        $this->renderable(function (RouteNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 404);
            }
        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['status' => false, 'message' => 'Too many attempts, please wait for some time before trying again'], 429);
            }
        });

        $this->renderable(function (AuthenticationException  $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
            }
        });


        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
