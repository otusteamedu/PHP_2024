<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RequestEntity;
use App\ValueObject\DataValueObject;
use App\ValueObject\IdValueObject;
use App\ValueObject\StatusValueObject;
use Doctrine\DBAL\Connection;

readonly class RequestRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function getRequestStatus(string $id): ?string
    {
        $result = $this->db->fetchAssociative('SELECT status FROM requests WHERE id = ?', [$id]);
        return $result ? $result['status'] : null;
    }

    public function updateRequestStatus(RequestEntity $requestEntity): void
    {
        $this->db->executeStatement(
            'UPDATE requests SET status = ? WHERE id = ?',
            [$requestEntity->getStatus()->value, $requestEntity->getId()->value]
        );
    }

    public function createRequest(RequestEntity $requestEntity): void
    {
        $this->db->insert('requests', [
            'id' => $requestEntity->getId()->value,
            'status' => $requestEntity->getStatus()->value,
            'data' => json_encode($requestEntity->getData()->value)
        ]);
    }

    public function finById(string $id): ?RequestEntity
    {
        $result = $this->db->fetchAssociative('SELECT * FROM requests WHERE id = ?', [$id]);
        return new RequestEntity(
            new IdValueObject($result['id']),
            new DataValueObject(json_decode($result['data'], true)),
            StatusValueObject::from($result['status'])
        );
    }
}
