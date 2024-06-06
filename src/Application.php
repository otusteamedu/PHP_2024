<?php

declare(strict_types=1);

namespace Pozys\BankStatement;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

class Application
{
    private Psr17Factory $psr17Factory;

    public function __construct()
    {
        $this->psr17Factory = new Psr17Factory();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $responseBody = $this->psr17Factory->createStream('Hello world');

        return $this->psr17Factory->createResponse(200)->withBody($responseBody);
    }
}
