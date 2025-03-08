<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\CreateNews;

class CreateNewsRequest
{
    public function __construct(
        public readonly string $url
    ) {
        // Empty constructor
    }
}
