<?php

namespace AnatolyShilyaev\Backend\Domain\CourtParseStatus\Repository;

use AnatolyShilyaev\Backend\Domain\CourtParseStatus\Entity\CourtParseStatus;

interface CourtParseStatusRepositoryInterface
{
    public function update(CourtParseStatus $courtParseStatus): void;
    public function getAll(): iterable;
}
