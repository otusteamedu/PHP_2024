<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Contract\RepositoryInterface;

final readonly class CreateNews
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    /**
     */
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $news = $this->repository->save((array)$request);

        return new CreateNewsResponse($news->getId());
    }
}
