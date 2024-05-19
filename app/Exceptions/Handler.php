<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if (
            $request->expectsJson() &&
            !$exception instanceof ValidationException
        ) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'The resource was not found',
                    'status' => 404,
                ], 404);
            } elseif ($exception instanceof AuthorizationException) {
                $status = $exception->getCode() == 0 ?
                    403 : $exception->getCode();
            } else {
                if (method_exists($exception, 'getStatusCode')) {
                    $status = $exception->getStatusCode();
                } else {
                    $status = 500;
                }
            }

            $message = $exception->getMessage() ?: 'An error occurred';

            return response()->json([
                'success' => false,
                'message' => $message,
                'status' => $status,
            ], $status);
        }

        return parent::render($request, $exception);
    }
}
