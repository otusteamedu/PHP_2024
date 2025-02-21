<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\CreateNews;

class CreateNewsResponse
{
    public function __construct(
        public readonly int $id,
    ) {
        // Empty constructor
    }
}
