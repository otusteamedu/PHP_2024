<?php

namespace AnatolyShilyaev\Backend\Domain\Event\Entity;

use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Basis;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Location;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Notes;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\PostingDate;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Result;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\ResultDate;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\ResultTime;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Title;

class Event
{
    public function __construct(
        private CourtCaseID $courtCaseID,
        private Title $title,
        private ResultDate $resultDate,
        private ResultTime $resultTime,
        private Location $location,
        private Result $result,
        private Basis $basis,
        private Notes $notes,
        private PostingDate $postingDate,
        private ?string $id = null,
    ) {
        // Empty constructor
    }

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getCourtCaseID(): CourtCaseID
    {
        return $this->courtCaseID;
    }
    public function getTitle(): Title
    {
        return $this->title;
    }
    public function getResultDate(): ResultDate
    {
        return $this->resultDate;
    }
    public function getResultTime(): ResultTime
    {
        return $this->resultTime;
    }
    public function getLocation(): Location
    {
        return $this->location;
    }
    public function getResult(): Result
    {
        return $this->result;
    }
    public function getBasis(): Basis
    {
        return $this->basis;
    }
    public function getNotes(): Notes
    {
        return $this->notes;
    }
    public function getPostingDate(): PostingDate
    {
        return $this->postingDate;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'courtCaseID' => $this->courtCaseID->getValue(),
            'title' => $this->title->getValue(),
            'resultDate' => $this->resultDate->getValue()
                ? $this->resultDate->getValue()->format('Y-m-d')
                : null,
            'resultTime' => $this->resultTime->getValue()
                ? $this->resultTime->getValue()->format('H:i:s')
                : null,
            'location' => $this->location->getValue(),
            'result' => $this->result->getValue(),
            'basis' => $this->basis->getValue(),
            'notes' => $this->notes->getValue(),
            'postingDate' => $this->postingDate->getValue()
                ? $this->postingDate->getValue()->format('Y-m-d')
                : null,
        ];
    }
}
