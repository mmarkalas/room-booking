<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $statusCode = $this->isInvalidStatusCode($exception->getCode())
            ? 500
            : $exception->getCode();

        $errorArray = [
            'code'      =>  $statusCode,
            'message'   =>  $exception->getMessage()
        ];

        if ($exception instanceof ValidationException) {
            throw new ApiException(
                $exception->getMessage(),
                $exception->getResponse()
                    ? $exception->getResponse()->getStatusCode()
                    : Response::HTTP_UNPROCESSABLE_ENTITY,
                $exception->errors()
            );
        }

        if ($exception instanceof ModelNotFoundException) {
            throw new ApiException(
                __('responses.not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        if ($exception instanceof ApiException) {
            return $exception->getResponse();
        }

        return response()->json(['error' => $errorArray,], $statusCode);
    }

    /**
     * Check if Status Code is Valid HTTP Code
     *
     * @param [type] $code
     * @return boolean
     */
    private function isInvalidStatusCode($code): bool
    {
        return $code < 100 || $code >= 600;
    }
}
