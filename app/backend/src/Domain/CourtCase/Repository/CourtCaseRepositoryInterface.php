<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCase\Repository;

use AnatolyShilyaev\Backend\Domain\CourtCase\Entity\CourtCase;

interface CourtCaseRepositoryInterface
{
    public function save(CourtCase $courtCase): void;

    public function update(CourtCase $courtCase): void;

    public function upload(array $courtCases): void;

    public function getAll(): iterable;

    public function getTotalCount(): int;
}
