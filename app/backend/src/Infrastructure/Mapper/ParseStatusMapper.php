<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Mapper;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Entity\ParseStatus;
use AnatolyShilyaev\Backend\Domain\ParseStatus\ValueObject\Status;
use AnatolyShilyaev\Backend\Infrastructure\Factory\ParseStatusFactory;
use PDO;

class ParseStatusMapper
{
    private PDO $pdo;
    private ParseStatusFactory $factory;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->factory = new ParseStatusFactory();
    }

    public function getStatus(): ParseStatus
    {
        $stmt = $this->pdo->prepare("SELECT status FROM parse_status");
        $stmt->execute();
        $parseStatus = [];

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $parseStatus = $this->hydrate($data);

        return $parseStatus;
    }

    public function updateStatus(ParseStatus $status): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE parse_status 
             SET status = :status
             WHERE id = 1"
        );

        $stmt->execute([
            'status' => $status->getStatus()->getValue(),
        ]);
    }

    private function hydrate(array $data): ParseStatus
    {
        $status = new Status($data['status']);

        return $this->factory->create(
            $status,
        );
    }
}
