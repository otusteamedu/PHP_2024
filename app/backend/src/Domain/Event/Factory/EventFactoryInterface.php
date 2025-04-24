<?php

namespace AnatolyShilyaev\Backend\Domain\Event\Factory;

use AnatolyShilyaev\Backend\Domain\Event\Entity\Event;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Basis;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Location;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Notes;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\PostingDate;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Result;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\ResultDate;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\ResultTime;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Title;

interface EventFactoryInterface
{
    public function create(
        CourtCaseID $courtCaseID,
        Title $title,
        ResultDate $resultDate,
        ResultTime $resultTime,
        Location $location,
        Result $result,
        Basis $basis,
        Notes $notes,
        PostingDate $postingDate,
        ?string $id = null,
    ): Event;
}
