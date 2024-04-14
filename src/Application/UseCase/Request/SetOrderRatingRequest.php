<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Application\UseCase\Request;

class SetOrderRatingRequest
{
    public function __construct(
        public int $id,
        public int $rating
    )
    {
    }
}