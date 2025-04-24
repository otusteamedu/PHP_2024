<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCase\Factory;

use AnatolyShilyaev\Backend\Domain\CourtCase\Entity\CourtCase;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;

interface CourtCaseFactoryInterface
{
    public function create(
        Title $title,
        GeneralNumber $generalNumber,
        Uid $uid,
        CaseNumber $caseNumber,
        Url $url,
        JudgeFio $judgeFio,
        RegisterDate $registerDate,
        array $events,
        array $parties,
        ?string $id = null,
    ): CourtCase;
}
