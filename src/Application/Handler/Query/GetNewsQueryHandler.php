<?php

declare(strict_types=1);

namespace App\Application\Handler\Query;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;
use Ecotone\Modelling\Attribute\QueryHandler;
use App\Application\Query\GetNewsQuery;

class GetNewsQueryHandler
{
    public function __construct(
        private NewsInterface $newsRepository
    ) {}

    /**
     * @return News[]
     */
    #[QueryHandler]
    public function __invoke(GetNewsQuery $query): array
    {
        return $this->newsRepository->findByParams([]);
    }
}
