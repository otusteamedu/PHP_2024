<?php

namespace Application\Gateway;

class NewsGatewayResponse
{
    public function __construct(
        public readonly string $title
    )
    {
    }

}
