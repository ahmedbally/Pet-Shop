<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseResource;

class JsonResource extends BaseResource
{

    private $success = 1;

    private $status = null;

    private $headers = [];

    private $error = null;

    private $errors = [];

    private $trace = [];

    private $extra = [];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        if ($this->success)
            $extra = ['extra' => $this->extra];
        else
            $extra = ['trace' => $this->trace];
        return [
            'success' => $this->success,
            'error' => $this->error,
            'errors' => $this->errors,
        ]+$extra;
    }

    public function success()
    {
        $this->success = 1;
        return $this;
    }

    public function error(string $error = '')
    {
        $this->success = 0;
        $this->status = 500;
        $this->error = $error;
        return $this;
    }

    public function errors(array $errors = [])
    {
        $this->errors = $errors;
        return $this;
    }

    public function trace(array $trace = [])
    {
        $this->trace = $trace;
        return $this;
    }

    public function status(int $value)
    {
        $this->status = $value;
        return $this;
    }

    public function headers(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->status ?? $response->getStatusCode())
            ->withHeaders($this->headers);
    }
}
