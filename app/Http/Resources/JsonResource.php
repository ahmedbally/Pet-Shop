<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseResource;

class JsonResource extends BaseResource
{

    private $success = 1;

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

    public function error($error = '')
    {
        $this->success = 0;
        $this->error = $error;
        return $this;
    }

    public function errors($errors = [])
    {
        $this->errors = $errors;
        return $this;
    }

    public function trace($trace = [])
    {
        $this->trace = $trace;
        return $this;
    }


}
