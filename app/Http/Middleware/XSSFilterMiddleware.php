<?php

namespace App\Http\Middleware;

use GrahamCampbell\Security\Facades\Security;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class XSSFilterMiddleware extends TransformsRequest
{
    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        return app('security')->clean($value);
    }
}
