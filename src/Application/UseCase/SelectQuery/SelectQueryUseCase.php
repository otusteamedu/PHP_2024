<?php

namespace App\Application\UseCase\SelectQuery;

use App\Application\EventSubscriber\QueryBuilder\QueryBuilderSubscriber;
use App\Application\Publisher\QueryBuilder\QueryBuilderPublisher;
use App\Domain\SelectQuery\DatabaseQueryResult;
use App\Infrastructure\QueryBuilder\SelectQueryBuilder;

class SelectQueryUseCase
{
    public function __invoke(SelectQueryRequest $request): SelectQueryResponse
    {
        return new SelectQueryResponse($this->getSelectQueryResponse($request));
    }

    private function getSelectQueryResponse(
        SelectQueryRequest $request
    ): DatabaseQueryResult {
        $publisher = new QueryBuilderPublisher();
        $publisher->subscribe(new QueryBuilderSubscriber());

        $queryBuilder = new SelectQueryBuilder($publisher);
        return $queryBuilder
            ->from($request->from)
            ->whereDTO($request->where)
            ->limit($request->limit)
            ->execute($request->lazy);
    }
}
