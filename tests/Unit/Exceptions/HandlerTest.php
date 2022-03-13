<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\Handler;
use Illuminate\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Session\TokenMismatchException;
use Tests\TestCase;

/**
 * Class HandlerTest.
 *
 * @covers \App\Exceptions\Handler
 */
class HandlerTest extends TestCase
{
    public function test_render(): void
    {
        $request = new Request();
        $request->headers->set('Accept','application/json');
        $handler = new Handler($this->createMock(Container::class));
        $response = $handler->render(
            $request,
            $this->createMock(\Exception::class)
        );
        $this->assertInstanceOf(
            JsonResponse::class,
            $response
        );

        $this->assertJson($response->getContent());
    }
}
