<?php

namespace App\Controller\Http\News\GetAllNews\v1;

use App\Application\UseCase\News\GetAllNews\GetAllNewsUseCaseResponse;
use App\Domain\Contract\Application\UseCase\GetAllNewsUseCaseInterface;

class ControllerManager
{
    public function __construct(
        private readonly GetAllNewsUseCaseInterface $getNewsListUseCase,
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
