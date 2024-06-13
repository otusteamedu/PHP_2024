<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Response\News;

class AddNewsResponse
{
    public function __construct(readonly private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
