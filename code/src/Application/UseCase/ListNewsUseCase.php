<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Domain;

class ListNewsUseCase
{
    public function __construct(
        private Domain\Repository\NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(Request\ListNewsItemRequest $request): Response\ListNewsItemResponse
    {
        if ($request->pageSize > 0) {
            $result = $this->newsRepository->getByPage($request->pageNumber, $request->pageSize);
        } else {
            $result = $this->newsRepository->getAll();
        }

        return new Response\ListNewsItemResponse($result);
    }
}
