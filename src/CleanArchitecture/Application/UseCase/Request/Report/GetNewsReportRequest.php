<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\Report;

use Symfony\Component\Validator\Constraints as Assert;

class GetNewsReportRequest
{
    #[Assert\NotNull]
    #[Assert\Type('string')]
    readonly private mixed $filename;

    public function __construct(mixed $filename)
    {
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return (string)$this->filename;
    }
}
