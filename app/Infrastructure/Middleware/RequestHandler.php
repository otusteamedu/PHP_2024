<?php

namespace App\Infrastructure\Middleware;


use Illuminate\Http\Request;

abstract class RequestHandler
{

    public function __construct(
        private ?RequestHandler $nextHandler = null,
    )
    {
    }

    public function setNext(RequestHandler $nextHandler): RequestHandler
    {
        $this->nextHandler = $nextHandler;
        return $nextHandler;
    }

    public function handle(Request $request): void
    {
        $this->nextHandler?->handle($request);
    }
}
