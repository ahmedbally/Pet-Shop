<?php

namespace App\Exceptions;

use App\Http\Resources\BaseResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Request;
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
        $response = BaseResource::make([])
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

        if ($e instanceof ValidationException) {
            $response->errors($e->errors());
        }
        return $response->response()
            ->setStatusCode($e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500)
            ->withHeaders($e instanceof HttpExceptionInterface ? $e->getHeaders() : []);
    }
}
