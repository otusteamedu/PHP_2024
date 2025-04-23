<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Repository;

interface CourtCaseWithStatusRepositoryInterface
{
    public function getAll(): iterable;
}
