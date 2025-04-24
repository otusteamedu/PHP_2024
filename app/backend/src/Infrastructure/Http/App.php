<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Backend\Infrastructure\Http;

use AnatolyShilyaev\Backend\Application\UseCase\GetAllCourtCases\GetAllCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\GetCourtCasesWithStatus\GetCourtCasesWithStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\GetParseStatus\GetParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\GetTotalCountCourtCases\GetTotalCountCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\ParseCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus\UpdateCourtParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase\UpdateParsedCourtCaseUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParseStatus\UpdateParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UploadCourtCases\UploadCourtCasesUseCase;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseWithStatusFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtParseStatusFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\EventFactory;
use AnatolyShilyaev\Backend\Infrastructure\Factory\ParseStatusFactory;
use AnatolyShilyaev\Backend\Infrastructure\Http\Controllers\CourtCase\UploadController as UploadCourtCaseController;
use AnatolyShilyaev\Backend\Infrastructure\Http\Controllers\CourtCaseWithStatuses\GetController as GetCourtCaseWithStatusesController;
use AnatolyShilyaev\Backend\Infrastructure\Http\Controllers\ParseStatus\GetController as GetParseStatusController;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseWithStatusRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtParseStatusRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\EventRepository;
use AnatolyShilyaev\Backend\Infrastructure\Repository\ParseStatusRepository;

class App
{
    private Router $router;

    private CourtCaseFactory $courtCaseFactory;
    private CourtCaseRepository $courtCaseRepository;

    private CourtParseStatusFactory $courtParseStatusFactory;
    private CourtParseStatusRepository $courtParseStatusRepository;

    private CourtCaseWithStatusFactory $courtCaseWithStatusFactory;
    private CourtCaseWithStatusRepository $courtCaseWithStatusRepository;

    private ParseStatusFactory $parseStatusFactory;
    private ParseStatusRepository $parseStatusRepository;

    private EventFactory $eventFactory;
    private EventRepository $eventRepository;

    private UploadCourtCasesUseCase $uploadCourtCasesUseCase;
    private UpdateParsedCourtCaseUseCase $updateParsedCourtCaseUseCase;
    private UpdateCourtParseStatusUseCase $updateCourtParseStatusUseCase;
    private GetAllCourtCasesUseCase $getAllCourtCasesUseCase;
    private ParseCourtCasesUseCase $parseCourtCasesUseCase;
    private GetCourtCasesWithStatusUseCase $getCourtCasesWithStatusUseCase;
    private GetParseStatusUseCase $getParseStatusUseCase;
    private UpdateParseStatusUseCase $updateParseStatusUseCase;
    private GetTotalCountCourtCasesUseCase $getTotalCountCourtCasesUseCase;

    private UploadCourtCaseController $uploadCourtCasesController;
    private GetCourtCaseWithStatusesController $getCourtCaseWithStatusesController;
    private GetParseStatusController $getParseStatusController;

    public function __construct()
    {
        $this->router = new Router();

        $this->courtCaseFactory = new CourtCaseFactory();
        $this->courtCaseRepository = new CourtCaseRepository();

        $this->courtParseStatusFactory = new CourtParseStatusFactory();
        $this->courtParseStatusRepository = new CourtParseStatusRepository();

        $this->parseStatusFactory = new ParseStatusFactory();
        $this->parseStatusRepository = new ParseStatusRepository();

        $this->courtCaseWithStatusFactory = new CourtCaseWithStatusFactory();
        $this->courtCaseWithStatusRepository = new CourtCaseWithStatusRepository();

        $this->eventFactory = new EventFactory();
        $this->eventRepository = new EventRepository();

        $this->uploadCourtCasesUseCase = new UploadCourtCasesUseCase($this->courtCaseFactory, $this->courtCaseRepository);
        $this->updateParsedCourtCaseUseCase = new UpdateParsedCourtCaseUseCase(
            $this->courtCaseFactory,
            $this->courtCaseRepository,
            $this->eventFactory,
            $this->eventRepository
        );
        $this->updateCourtParseStatusUseCase = new UpdateCourtParseStatusUseCase($this->courtParseStatusFactory, $this->courtParseStatusRepository);
        $this->getAllCourtCasesUseCase = new GetAllCourtCasesUseCase($this->courtCaseRepository);
        $this->getCourtCasesWithStatusUseCase = new GetCourtCasesWithStatusUseCase($this->courtCaseWithStatusRepository);
        $this->parseCourtCasesUseCase = new ParseCourtCasesUseCase();
        $this->getParseStatusUseCase = new GetParseStatusUseCase($this->parseStatusRepository);
        $this->updateParseStatusUseCase = new UpdateParseStatusUseCase($this->parseStatusFactory, $this->parseStatusRepository);
        $this->getTotalCountCourtCasesUseCase = new GetTotalCountCourtCasesUseCase($this->courtCaseRepository);

        $this->uploadCourtCasesController = new UploadCourtCaseController(
            $this->uploadCourtCasesUseCase,
            $this->updateParsedCourtCaseUseCase,
            $this->updateCourtParseStatusUseCase,
            $this->getAllCourtCasesUseCase,
            $this->parseCourtCasesUseCase,
            $this->updateParseStatusUseCase
        );
        $this->getCourtCaseWithStatusesController = new GetCourtCaseWithStatusesController(
            $this->getCourtCasesWithStatusUseCase,
            $this->getAllCourtCasesUseCase,
            $this->getTotalCountCourtCasesUseCase,
        );
        $this->getParseStatusController = new GetParseStatusController(
            $this->getParseStatusUseCase,
        );
    }

    public function __invoke(): void
    {
        $this->router->add('GET', '/api/status', $this->getParseStatusController);
        $this->router->add('GET', '/api/ready', $this->getCourtCaseWithStatusesController);
        $this->router->add('POST', '/api/upload', $this->uploadCourtCasesController);

        $response = $this->router->dispatch($_SERVER['REQUEST_URI']);

        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
