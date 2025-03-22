<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews;

use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class FindAllNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        // Empty constructor
    }

    /**
     * @return FindAllNewsResponse[] $newsArr
     */
    public function __invoke(): iterable
    {
        //Get all News
        $newsEntities = $this->newsRepository->findAll();

        // Create DTO array
        $findAllNewsResponses = [];
        foreach ($newsEntities as $newsEntity) {
            $findAllNewsResponses[] = new FindAllNewsResponse(
                $newsEntity->getTitle()->getValue(),
                $newsEntity->getUrl()->getValue(),
                $newsEntity->getDate()->getValue(),
            );
        }

        return $findAllNewsResponses;
    }
}
