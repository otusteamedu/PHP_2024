<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Backend\Infrastructure\Queue;

use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\GetCourtCaseHtmlUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\ParseCourtCaseFromHtmlUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus\UpdateCourtParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase\UpdateParsedCourtCaseUseCase;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtParseStatusFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\EventFactory;
use AnatolyShilyaev\Backend\Infrastructure\Queue\RabbitMQConsumer;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtParseStatusRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\EventRepository;

require '/app/backend/vendor/autoload.php';

class QueueWorker
{
    private RabbitMQConsumer $consumer;

    private CourtCaseFactory $courtCaseFactory;
    private CourtCaseRepository $courtCaseRepository;

    private CourtParseStatusFactory $courtParseStatusFactory;
    private CourtParseStatusRepository $courtParseStatusRepository;

    private EventFactory $eventFactory;
    private EventRepository $eventRepository;

    private UpdateParsedCourtCaseUseCase $updateParsedCourtCaseUseCase;
    private UpdateCourtParseStatusUseCase $updateCourtParseStatusUseCase;
    private GetCourtCaseHtmlUseCase $getCourtCaseHtmlUseCase;
    private ParseCourtCaseFromHtmlUseCase $parseCourtCaseFromHtmlUseCase;

    public function __construct()
    {
        $this->courtCaseFactory = new CourtCaseFactory();
        $this->courtCaseRepository = new CourtCaseRepository();

        $this->courtParseStatusFactory = new CourtParseStatusFactory();
        $this->courtParseStatusRepository = new CourtParseStatusRepository();

        $this->eventFactory = new EventFactory();
        $this->eventRepository = new EventRepository();

        $this->updateParsedCourtCaseUseCase = new UpdateParsedCourtCaseUseCase(
            $this->courtCaseFactory,
            $this->courtCaseRepository,
            $this->eventFactory,
            $this->eventRepository
        );
        $this->updateCourtParseStatusUseCase = new UpdateCourtParseStatusUseCase($this->courtParseStatusFactory, $this->courtParseStatusRepository);
        $this->getCourtCaseHtmlUseCase = new GetCourtCaseHtmlUseCase();
        $this->parseCourtCaseFromHtmlUseCase = new ParseCourtCaseFromHtmlUseCase();

        $this->consumer = new RabbitMQConsumer(
            $this->updateParsedCourtCaseUseCase,
            $this->updateCourtParseStatusUseCase,
            $this->getCourtCaseHtmlUseCase,
            $this->parseCourtCaseFromHtmlUseCase
        );
    }

    public function __invoke(): void
    {
        ($this->consumer)();
    }
}

(new QueueWorker())();
