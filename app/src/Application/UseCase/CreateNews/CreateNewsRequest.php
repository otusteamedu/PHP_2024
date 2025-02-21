<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\CreateNews;

class CreateNewsRequest
{
    public function __construct(
        public readonly string $url,
    ) {
        // Empty constructor
    }
}
