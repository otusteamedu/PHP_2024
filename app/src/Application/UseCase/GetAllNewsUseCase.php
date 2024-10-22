<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\NewsList\NewsListGeneratorInterface;

class GetAllNewsUseCase
{
    public function __construct(private readonly NewsListGeneratorInterface $listGenerator)
    {
    }

    public function __invoke(): array
    {
        return $this->listGenerator->generate();
    }
}
