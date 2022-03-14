<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as BaseResource;

class JsonResource extends BaseResource
{
    /**
     * @var int
     */
    private $success = 1;

    /**
     * @var int|null
     */
    private $status = null;

    /**
     * @var array<string,string>
     */
    private $headers = [];

    /**
     * @var string|null
     */
    private $error = null;

    /**
     * @var array<string,string|array<string>>
     */
    private $errors = [];

    /**
     * @var array<string,string>
     */
    private $trace = [];

    /**
     * @var array<string,string|array<string>>
     */
    private $extra = [];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @phpstan-ignore-next-line
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * Additional data
     *
     * @param Request $request
     * @phpstan-ignore-next-line
     * @return  array
     */
    public function with($request): array
    {
        if ($this->success) {
            $extra = ['extra' => $this->extra];
        } else {
            $extra = ['trace' => $this->trace];
        }

        return [
            'success' => $this->success,
            'error' => $this->error,
            'errors' => $this->errors,
        ] + $extra;
    }

    /**
     * Set Response as success
     *
     * @return $this
     */
    public function success(): JsonResource
    {
        $this->success = 1;

        return $this;
    }

    /**
     * Set response as error
     *
     * @param string $error
     * @return $this
     */
    public function error(string $error = ''): JsonResource
    {
        $this->success = 0;
        $this->status = 500;
        $this->error = $error;

        return $this;
    }

    /**
     * Set validation errors
     *
     * @param array<string,string|array<string>> $errors
     * @return $this
     */
    public function errors(array $errors = []): JsonResource
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Set trace error
     *
     * @param array<string,string> $trace
     * @return $this
     */
    public function trace(array $trace = []): JsonResource
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * Set status code
     *
     * @param int $value
     * @return $this
     */
    public function status(int $value): JsonResource
    {
        $this->status = $value;

        return $this;
    }

    /**
     * Set additional headers
     *
     * @param array<string,string> $headers
     * @return $this
     */
    public function headers(array $headers): JsonResource
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Edit response
     *
     * @param Request $request
     * @param JsonResponse $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->status ?? $response->getStatusCode())
            ->withHeaders($this->headers);
    }
}
