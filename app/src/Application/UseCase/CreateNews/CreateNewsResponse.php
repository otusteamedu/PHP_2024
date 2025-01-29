<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\CreateNews;

class CreateNewsResponse
{
    public function __construct(
        public readonly int $id,
    ) {
        // Empty constructor
    }
}
