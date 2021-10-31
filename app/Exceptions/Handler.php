<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use App\Traits\ApiJsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiJsonResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
        if ($e instanceof AuthenticationException) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse(null, 'The requested URL is invalid', Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof HttpClientException) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof AuthorizationException) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof ThrottleRequestsException) {
            return $this->errorResponse(null, $e->getMessage(), Response::HTTP_TOO_MANY_REQUESTS);
        }

        if ($e instanceof ValidationException) {
            return parent::render($request, $e);
        }

        return $this->throwableFatalErrorResponse($e, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
