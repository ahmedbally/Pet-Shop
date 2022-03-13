<?php

namespace App\Exceptions;

use App\Http\Resources\JsonResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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

    protected function prepareJsonResponse($request, Throwable $e)
    {
        $response = JsonResource::make([])
            ->error(config('app.debug') ?
                $e->getMessage()
                : ($this->isHttpException($e) ?
                    $e->getMessage()
                    : 'Server Error')
            );

        if(config('app.debug')){
            $response->trace(collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all());
        }

        if ($e instanceof HttpExceptionInterface) {
            $response->status($e->getStatusCode());
            $response->headers($e->getHeaders());
        }

        if ($e instanceof ValidationException) {
            $response->status($e->status);
            $response->errors($e->errors());
        }
        return $response->response();
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {

        return $this->shouldReturnJson($request, $exception)
            ? JsonResource::make([])->error($exception->getMessage())->response()->setStatusCode(401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->prepareJsonResponse($request, $exception);
    }
}
