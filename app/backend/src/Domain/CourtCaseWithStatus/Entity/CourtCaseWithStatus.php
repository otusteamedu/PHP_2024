<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Entity;

use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;

class CourtCaseWithStatus
{
    public function __construct(
        private Title $title,
        private GeneralNumber $generalNumber,
        private Uid $uid,
        private CaseNumber $caseNumber,
        private Url $url,
        private JudgeFio $judgeFio,
        private RegisterDate $registerDate,
        private Status $status,
        private ErrorType $errorType,
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
    public function getStatus(): Status
    {
        return $this->status;
    }
    public function getErrorType(): ErrorType
    {
        return $this->errorType;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title->getValue(),
            'generalNumber' => $this->generalNumber->getValue(),
            'uid' => $this->uid->getValue(),
            'caseNumber' => $this->caseNumber->getValue(),
            'url' => $this->url->getValue(),
            'judgeFio' => $this->judgeFio->getValue(),
            'registerDate' => $this->registerDate->getValue()
                ? $this->registerDate->getValue()->format('Y-m-d')
                : null,
            'status' => $this->status->getValue(),
            'errorType' => $this->errorType->getValue(),
            'events' => $this->events,
            'events' => array_map(
                fn($event) => $event->toArray(),
                $this->events
            ),
            'parties' => $this->parties,
        ];
    }
}
