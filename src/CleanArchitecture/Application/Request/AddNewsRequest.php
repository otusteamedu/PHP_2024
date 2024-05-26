<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Request;

use Symfony\Component\Validator\Constraints as Assert;

class AddNewsRequest
{
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Url]
    readonly private mixed $url;

    public function __construct(mixed $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return (string)$this->url;
    }
}
