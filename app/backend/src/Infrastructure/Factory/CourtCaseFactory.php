<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Factory;

use AnatolyShilyaev\Backend\Domain\CourtCase\Entity\CourtCase;
use AnatolyShilyaev\Backend\Domain\CourtCase\Factory\CourtCaseFactoryInterface;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;

class CourtCaseFactory implements CourtCaseFactoryInterface
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
    ): CourtCase {
        return new CourtCase(
            $title,
            $generalNumber,
            $uid,
            $caseNumber,
            $url,
            $judgeFio,
            $registerDate,
            $events,
            $parties,
            $id,
        );
    }
}
