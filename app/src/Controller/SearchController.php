<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Controller;

use AlexanderPogorelov\Redis\Config;
use AlexanderPogorelov\Redis\Repository\EventRepositoryInterface;
use AlexanderPogorelov\Redis\Response\ResponseInterface;
use AlexanderPogorelov\Redis\Response\SearchResponse;
use AlexanderPogorelov\Redis\Search\SearchCriteria;
use AlexanderPogorelov\Redis\Service\PromptService;
use AlexanderPogorelov\Redis\Validator\PromptValidator;

readonly class SearchController
{
    public function __construct(private EventRepositoryInterface $repository)
    {
    }

    public function searchAction(): ResponseInterface
    {
        $searchData = (new PromptService(new PromptValidator(), new Config()))->readInput();
        $result = $this->repository->findByCriteria(new SearchCriteria($searchData));

        return new SearchResponse($result);
    }
}
