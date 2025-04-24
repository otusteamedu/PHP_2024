<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Repository;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Entity\ParseStatus;
use AnatolyShilyaev\Backend\Domain\ParseStatus\Repository\ParseStatusRepositoryInterface;
use AnatolyShilyaev\Backend\Infrastructure\Config\Connection;
use AnatolyShilyaev\Backend\Infrastructure\Mapper\ParseStatusMapper;

class ParseStatusRepository implements ParseStatusRepositoryInterface
{
    private ParseStatusMapper $mapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->mapper = new ParseStatusMapper($pdo);
    }

    public function getStatus(): ParseStatus
    {
        $parseStatus = $this->mapper->getStatus();
        return $parseStatus;
    }
    public function updateStatus(ParseStatus $status): void
    {
        $this->mapper->updateStatus($status);
    }
}
