<?php

namespace App\Domain\Service;

use App\Application\UseCase\SelectQuery\SelectQueryRequest;
use App\Application\UseCase\SelectQuery\SelectQueryUseCase;
use App\Domain\DTO\SelectQuery\WhereDTO;
use App\Domain\Enum\ServiceMessage;

class SelectQueryService
{
    public function executeSelectQuery(string $json): string
    {
        $selectQueryAsArray = $this->jsonToArray($json);

        $selectQueryRequest = new SelectQueryRequest(
            $selectQueryAsArray['from'],
            $this->getWhereDTOArray($selectQueryAsArray['where']) ?? null,
            $selectQueryAsArray['orderBy'] ?? null,
            $selectQueryAsArray['direction'] ?? null,
            $selectQueryAsArray['limit'] ?? null,
            $selectQueryAsArray['offset'] ?? null,
            $selectQueryAsArray['lazy'] ?? null,
        );

        $response = (new SelectQueryUseCase())($selectQueryRequest);

        if (isset($response->queryResult->collection)) {
            return ServiceMessage::QuerySelectSuccess->value
                . json_encode($response->queryResult->getCollection(), JSON_UNESCAPED_UNICODE);
        }

        return ServiceMessage::QuerySelectError->value;
    }

    /**
     * @param array|null $whereArray
     * @return WhereDTO[]|null
     */
    private function getWhereDTOArray(?array $whereArray): ?array
    {
        if ($whereArray === null) {
            return null;
        }
        $whereDTOArray = [];
        foreach ($whereArray as $where) {
            $whereDTOArray[] = new WhereDTO(
                $where['attribute'],
                $where['value'],
                $where['operator'] ?? null,
            );
        }

        return $whereDTOArray;
    }

    private function jsonToArray(string $json): array
    {
        return json_decode($json, true);
    }
}
