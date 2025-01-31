<?php

namespace Application\Gateway;

class NewsGatewayRequest
{
    public function __construct(
        public readonly string $url,
    )
    {
    }

}
