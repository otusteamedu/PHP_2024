<?php

namespace App\Infrastructure\Middleware;

use Illuminate\Http\Request;

class Middleware
{
    public function __construct(
        private readonly RequestHandler $firstHandler,
    )
    {
    }

    public function validate(Request $request): void
    {
        $this->firstHandler->handle($request);
    }
}
