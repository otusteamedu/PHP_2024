<?php

declare(strict_types=1);

namespace App\Application\Handler\Query;

use App\Domain\Database\QueryInterface;
use Ecotone\Modelling\Attribute\QueryHandler;
use App\Application\Query\GetNewsQuery;

readonly class GetNewsQueryHandler
{
    public function __construct(
        private QueryInterface $databaseQuery
    ) {}

    /**
     * @param GetNewsQuery $query
     * @return array
     */
    #[QueryHandler]
    public function __invoke(GetNewsQuery $query): array
    {
        return $this->databaseQuery->getNewsByUuid($query->getUuid()->getValue());
    }
}
