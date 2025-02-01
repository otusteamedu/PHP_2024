<?php

namespace Src\Application\Gateway;

class RedisGatewayResponse
{
    public array $dictionary;
    public function __construct(
        array $dictionary
    )
    {
        $this->dictionary = $dictionary;
    }
}