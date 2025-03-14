<?php

namespace App\Infrastructure\Middleware;

use App\Infrastructure\Middleware\RequestHandler;
use Illuminate\Http\Request;

class BlacklistedIpRequestHandler extends RequestHandler
{
    public function handle(Request $request): void
    {
        if ($request->ip() == '172.21.0.2') {
            throw new \Exception("This IP ({$request->ip()}) is not allowed", 403);
        }
        parent::handle($request);
    }
}
