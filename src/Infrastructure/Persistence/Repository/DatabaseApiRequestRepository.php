<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Entity\ApiRequest\{ApiRequest, ApiRequestNotFoundException, ApiRequestRepositoryInterface};
use ReflectionClass;

class DatabaseApiRequestRepository extends AbstractDatabaseRepository implements ApiRequestRepositoryInterface
{
    protected static string $table = 'api_requests';

    public function find(int $id): ApiRequest
    {
        try {
            $apiRequest = parent::findById($id);
        } catch (DomainRecordNotFoundException $th) {
            throw new ApiRequestNotFoundException($id);
        }

        return ApiRequest::fromState($apiRequest);
    }

    public function store(ApiRequest $apiRequest): void
    {
        $id = $this->table()->insertGetId([
            'body' => $apiRequest->getBody()->getValue(),
            'status' => $apiRequest->getStatus()->value,
        ]);

        $apiRequest = $this->setId($apiRequest, $id);
    }

    public function update(ApiRequest $apiRequest): void
    {
        $this->table()
            ->where('id', $apiRequest->getId())
            ->update([
                'body' => $apiRequest->getBody()->getValue(),
                'status' => $apiRequest->getStatus()->value,
            ]);
    }

    private function setId(ApiRequest $apiRequest, int $id): ApiRequest
    {
        $reflectionClass = new ReflectionClass($apiRequest);
        $property = $reflectionClass->getProperty('id');
        $property->setValue($apiRequest, $id);

        return $apiRequest;
    }
}
