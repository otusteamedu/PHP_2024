<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Mapper;

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
use AnatolyShilyaev\Backend\Infrastructure\Factory\EventFactory;
use DateTimeImmutable;
use PDO;

class EventMapper
{
    private PDO $pdo;
    private EventFactory $factory;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->factory = new EventFactory();
    }

    public function save(Event $event): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO court_events (
                    court_case_id,
                    event_name,
                    result_date,
                    result_time,
                    location,
                    result,
                    basis_for_result,
                    notes,
                    posting_date
                )
            VALUES (
                    :court_case_id,
                    :event_name,
                    :result_date,
                    :result_time,
                    :location,
                    :result,
                    :basis_for_result,
                    :notes,
                    :posting_date
                )"
        );

        $stmt->execute([
            'court_case_id' => $event->getCourtCaseID()->getValue(),
            'event_name' => $event->getTitle()->getValue(),
            'result_date' => $event->getResultDate()->getValue()
                ? $event->getResultDate()->getValue()->format('Y-m-d')
                : null,
            'result_time' => $event->getResultTime()->getValue()
                ? $event->getResultTime()->getValue()->format('H:i:s')
                : null,
            'location' => $event->getLocation()->getValue(),
            'result' => $event->getResult()->getValue(),
            'basis_for_result' => $event->getBasis()->getValue(),
            'notes' => $event->getNotes()->getValue(),
            'posting_date' => $event->getPostingDate()->getValue()
                ? $event->getPostingDate()->getValue()->format('Y-m-d')
                : null,
        ]);
    }

    public function getByID(CourtCaseID $courtCaseID): iterable
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM court_events
            WHERE court_case_id = :court_case_id
            ORDER BY 
            result_date DESC, 
            result_time DESC
        ");
        $stmt->execute(['court_case_id' => $courtCaseID->getValue()]);
        $events = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] =  $this->hydrate($data);
        }

        return $events;
    }

    private function hydrate(array $data): Event
    {
        $id = $data['id'];
        $courtCaseID = new CourtCaseID($data['court_case_id']);
        $title = new Title($data['event_name']);
        $resultDate = isset($data['result_date'])
            ? new ResultDate(new \DateTimeImmutable($data['result_date']))
            : new ResultDate(null);
        $resultTime = isset($data['result_time'])
            ? new ResultTime(new \DateTimeImmutable($data['result_time']))
            : new ResultTime(null);
        $result = new Result($data['result']);
        $location = new Location($data['location']);
        $basis = new Basis($data['basis_for_result']);
        $notes = new Notes($data['notes']);
        $postingDate = isset($data['posting_date'])
            ? new PostingDate(new \DateTimeImmutable($data['posting_date']))
            : new PostingDate(null);

        return $this->factory->create(
            $courtCaseID,
            $title,
            $resultDate,
            $resultTime,
            $location,
            $result,
            $basis,
            $notes,
            $postingDate,
            $id,
        );
    }
}
