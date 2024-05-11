<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Response;

use Irayu\Hw15\Domain;

class ListNewsItemResponse implements DefaultNewsItemResponse
{
    public function __construct(
        /**
         * @var Domain\Entity\NewsItem[]
         */
        public readonly array $items,
    )
    {
    }
}