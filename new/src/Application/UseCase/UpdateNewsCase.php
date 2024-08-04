<?php

namespace Ahar\hw15\src\Application\UseCase;

use Ahar\hw15\src\Application\Dto\UpdateNewsRequest;
use Ahar\hw15\src\Application\Dto\UpdateResponse;
use Ahar\hw15\src\Domain\Contract\NewsRepositoryInterface;
use Ahar\hw15\src\Domain\Model\News;
use Throwable;

readonly class UpdateNewsCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository
    )
    {
    }

    public function handle(UpdateNewsRequest $createCinemaRequest): UpdateResponse
    {
        try {
            /**@var News $news */
            $news = $this->newsRepository->findOne($createCinemaRequest->id);

            if ($news === null) {
                throw new \DomainException('Not found', 400);
            }

            $news->setDescription($createCinemaRequest->description);
            $news->setTitle($createCinemaRequest->title);

            $this->newsRepository->save($news);

            $response = new UpdateResponse(
                200,
            );
        } catch (Throwable $e) {
            $response = new UpdateResponse(
                $e->getCode(),
                $e->getMessage(),
            );
        }

        return $response;
    }
}
