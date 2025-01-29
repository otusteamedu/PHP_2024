<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews;

/**
 * @param News[] $news
 */

class FindAllNewsResponse
{
    public function __construct(
        public readonly array $news,
    ) {
        // Empty constructor
    }
}
