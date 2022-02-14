<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

    protected function unauthenticated($request, AuthenticationException $exception){
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    public function render($request, \Throwable $exception)
    {
//        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
//            return response()->json(['message' => 'Not Found!'], 404);
//        }

        return match (get_class($exception)) {
            ModelNotFoundException::class, NotFoundHttpException::class => response()->json(['message' => 'Not Found!'], 404),
            MethodNotFoundException::class => response()->json(['message' => 'Not Found!'], 404),
            BadRequestException::class => response()->json(['message' => $exception->getMessage()], $exception->getCode()),
            default => parent::render($request, $exception),
        };
    }
}
