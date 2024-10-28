<?php

namespace App\Infrastructure\Controller\News\GetAllNews\v1;

use App\Application\UseCase\News\GetAllNews\GetAllNewsUseCaseResponse;
use App\Domain\Interface\UseCase\GetAllNewsUseCaseInterface;

class ControllerManager
{
    public function __construct(
        private GetAllNewsUseCaseInterface $getNewsListUseCase,
    ) {
    }

    /**
     * @return GetAllNewsUseCaseResponse[]
     */
    public function __invoke(): array
    {
        return ($this->getNewsListUseCase)();
    }
}
