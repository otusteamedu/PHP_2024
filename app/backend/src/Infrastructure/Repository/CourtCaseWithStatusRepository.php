<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Repository;

use AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Repository\CourtCaseWithStatusRepositoryInterface;
use AnatolyShilyaev\Backend\Infrastructure\Config\Connection;
use AnatolyShilyaev\Backend\Infrastructure\Mapper\CourtCaseMapper;
use AnatolyShilyaev\Backend\Infrastructure\Mapper\CourtCaseWithStatusMapper;

class CourtCaseWithStatusRepository implements CourtCaseWithStatusRepositoryInterface
{
    private CourtCaseWithStatusMapper $mapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->mapper = new CourtCaseWithStatusMapper($pdo);
    }

    /**
     * @return CourtCase[]
     */
    public function getAll(): iterable
    {
        $allCourtCases = $this->mapper->getAll();
        return $allCourtCases;
    }
}
