<?php

namespace Ahar\hw15\src\Application\UseCase;

use Ahar\hw15\src\Application\Dto\CreateNewsRequest;
use Ahar\hw15\src\Application\Dto\CreateResponse;
use Ahar\hw15\src\Domain\Contract\NewsRepositoryInterface;
use Ahar\hw15\src\Domain\Model\News;
use Throwable;

readonly class CreateNewsCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository
    )
    {
    }

    public function handle(CreateNewsRequest $createCinemaRequest): CreateResponse
    {
        try {
            $cinema = new News(
                $createCinemaRequest->title,
                $createCinemaRequest->description,
            );

            $this->newsRepository->save($cinema);

            $response = new CreateResponse(
                201,
                '',
            );
        } catch (Throwable $e) {
            $response = new CreateResponse(
                400,
                $e->getMessage(),
            );
        }

        return $response;
    }
}
