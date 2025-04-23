<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Repository;

use AnatolyShilyaev\Backend\Domain\CourtParseStatus\Entity\CourtParseStatus;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\Repository\CourtParseStatusRepositoryInterface;
use AnatolyShilyaev\Backend\Infrastructure\Config\Connection;
use AnatolyShilyaev\Backend\Infrastructure\Mapper\CourtParseStatusMapper;

class CourtParseStatusRepository implements CourtParseStatusRepositoryInterface
{
    private CourtParseStatusMapper $mapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->mapper = new CourtParseStatusMapper($pdo);
    }

    public function update(CourtParseStatus $courtParseStatus): void
    {
        $this->mapper->update($courtParseStatus);
    }

    public function getAll(): iterable
    {
        $courtParseStatuses = $this->mapper->getAll();
        return $courtParseStatuses;
    }
}
