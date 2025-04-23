<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCase\Entity;

use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;

class CourtCase
{
    public function __construct(
        private Title $title,
        private GeneralNumber $generalNumber,
        private Uid $uid,
        private CaseNumber $caseNumber,
        private Url $url,
        private JudgeFio $judgeFio,
        private RegisterDate $registerDate,
        private array $events,
        private array $parties,
        private ?string $id = null,
    ) {
        // Empty constructor
    }

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getTitle(): Title
    {
        return $this->title;
    }
    public function getGeneralNumber(): GeneralNumber
    {
        return $this->generalNumber;
    }
    public function getUid(): Uid
    {
        return $this->uid;
    }
    public function getCaseNumber(): CaseNumber
    {
        return $this->caseNumber;
    }
    public function getUrl(): Url
    {
        return $this->url;
    }
    public function getJudgeFio(): JudgeFio
    {
        return $this->judgeFio;
    }
    public function getRegisterDate(): RegisterDate
    {
        return $this->registerDate;
    }
    public function getEvents(): array
    {
        return $this->events;
    }
    public function getParties(): array
    {
        return $this->parties;
    }
}
