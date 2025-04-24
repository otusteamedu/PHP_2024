<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase;

use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Basis;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Location;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Notes;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\PostingDate;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Result;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\ResultDate;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\ResultTime;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\Title as EventTitle;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\EventFactory;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\EventRepository;
use DateTimeImmutable;

class UpdateParsedCourtCaseUseCase
{
    public function __construct(
        private readonly CourtCaseFactory $factory,
        private readonly CourtCaseRepository $repository,
        private readonly EventFactory $eventFactory,
        private readonly EventRepository $eventRepository,
    ) {
        // Empty constructor
    }

    public function __invoke(UpdateParsedCourtCaseRequest $request): void
    {

        //Prepare ValueObjects
        $id = $request->id;
        $title = new Title($request->title);
        $generalNumber = new GeneralNumber("");
        $uid = new Uid($request->uid);
        $caseNumber = new CaseNumber($request->caseNumber);
        $url = new Url();
        $judgeFio = new JudgeFio($request->judgeFio);
        $registerDate = isset($request->registerDate)
            ? new RegisterDate(new \DateTimeImmutable($request->registerDate))
            : new RegisterDate(null);

        // Create CourtCase
        $courtCase = $this->factory->create($title, $generalNumber, $uid, $caseNumber, $url, $judgeFio, $registerDate, [], [], $id);

        //Save CourtCase to DB
        $this->repository->update($courtCase);

        $events = $request->events;
        foreach ($events as $event) {
            $courtCaseID = new CourtCaseID($id);
            $eventTitle = new EventTitle($event['title']);
            $resultDate = isset($event['resultDate'])
                ? new ResultDate(new \DateTimeImmutable($event['resultDate']))
                : new ResultDate(null);
            $resultTime = isset($event['resultTime'])
                ? new ResultTime(new \DateTimeImmutable($event['resultTime']))
                : new ResultTime(null);
            $location = new Location($event['location']);
            $result = new Result($event['result']);
            $basis = new Basis($event['basis']);
            $notes = new Notes($event['notes']);
            $postingDate = isset($event['postingDate'])
                ? new PostingDate(new \DateTimeImmutable($event['postingDate']))
                : new PostingDate(null);

            $event = $this->eventFactory->create($courtCaseID, $eventTitle, $resultDate, $resultTime, $location, $result, $basis, $notes, $postingDate);

            //Save Event to DB
            $this->eventRepository->save($event);
        }
    }
}
