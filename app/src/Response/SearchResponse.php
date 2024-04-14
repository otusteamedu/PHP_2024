<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Response;

use AlexanderPogorelov\Redis\Entity\Event;

readonly class SearchResponse implements ResponseInterface
{
    public function __construct(private ?Event $event)
    {
    }

    /**
     * @throws \JsonException
     */
    public function showResponse(): void
    {
        if (null === $this->event) {
            echo 'No results found' . PHP_EOL;
            return;
        }

        echo 'The most relevant event:' . PHP_EOL;
        echo $this->event;
    }
}
