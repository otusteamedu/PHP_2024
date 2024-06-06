<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Http;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestCreatorFactory
{
    private ServerRequestCreator $serverRequestCreator;

    public function __construct()
    {
        $psr17Factory = new Psr17Factory();

        $this->serverRequestCreator = new ServerRequestCreator(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );
    }

    public function createServerRequestFromGlobals(): ServerRequestInterface
    {
        return $this->serverRequestCreator->fromGlobals();
    }
}
