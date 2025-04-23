<?php

namespace AnatolyShilyaev\Backend\Domain\ParseStatus\Repository;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Entity\ParseStatus;

interface ParseStatusRepositoryInterface
{
    public function getStatus(): ParseStatus;
    public function updateStatus(ParseStatus $status): void;
}
