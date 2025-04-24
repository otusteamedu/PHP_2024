<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Factory;

use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;
use AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Entity\CourtCaseWithStatus;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;

interface CourtCaseWithStatusFactoryInterface
{
    public function create(
        Title $title,
        GeneralNumber $generalNumber,
        Uid $uid,
        CaseNumber $caseNumber,
        Url $url,
        JudgeFio $judgeFio,
        RegisterDate $registerDate,
        Status $status,
        ErrorType $errorType,
        array $events,
        array $parties,
        ?string $id = null,
    ): CourtCaseWithStatus;
}
