<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw15;

use AnatolyShilyaev\Hw15\Application\UseCase\CreateNews\CreateNewsRequest;
use AnatolyShilyaev\Hw15\Application\UseCase\CreateNews\CreateNewsUseCase;
use AnatolyShilyaev\Hw15\Application\UseCase\FindAllNews\FindAllNewsUseCase;
use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsRequest;
use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsUseCase;
use AnatolyShilyaev\Hw15\Infrastructure\Factory\CommonNewsFactory;
use AnatolyShilyaev\Hw15\Infrastructure\Http\NewsController;
use AnatolyShilyaev\Hw15\Infrastructure\Repository\DBNewsRepository;

class App
{
    private Router $router;

    private CommonNewsFactory $CommonNewsFactory;
    private DBNewsRepository $DBNewsRepository;

    private CreateNewsUseCase $createNews;
    private FindAllNewsUseCase $findAllNews;
    private GetReportNewsUseCase $getReportNews;

    private NewsController $newsController;

    public function __construct()
    {
        $this->router = new Router();

        $this->CommonNewsFactory = new CommonNewsFactory();
        $this->DBNewsRepository = new DBNewsRepository();

        $this->createNews = new CreateNewsUseCase($this->CommonNewsFactory, $this->DBNewsRepository);
        $this->findAllNews = new FindAllNewsUseCase($this->CommonNewsFactory, $this->DBNewsRepository);
        $this->getReportNews = new GetReportNewsUseCase($this->CommonNewsFactory, $this->DBNewsRepository);

        $this->newsController = new NewsController(
            $this->createNews,
            $this->findAllNews,
            $this->getReportNews
        );
    }
    public function __invoke(): void
    {
        $this->router->add('/', function () {
            print_r("start page");
        });

        $this->router->add('/create', function () {
            // $url = "https://dev.to/jkettmann/path-to-a-cleaner-react-architecture-a-shared-api-client-2d4p";
            $url = "https://dev.to/jkettmann/path-to-a-cleaner-react-architecture-api-layer-fetch-functions-4jin";
            // $url = "https://dev.to/jkettmann/path-to-a-cleaner-react-architecture-api-layer-data-transformations-1go0";
            // $url = "https://dev.to/jkettmann/path-to-a-cleaner-react-architecture-domain-entities-dtos-3ja0";
            // $url = "https://dev.to/jkettmann/path-to-a-cleaner-react-architecture-part-5-infrastructure-services-dependency-injection-for-testability-586j";
            $createNewsRequest = new CreateNewsRequest($url);
            print_r($this->newsController->create($createNewsRequest));
        });

        $this->router->add('/findall', function () {
            print_r($this->newsController->findall());
        });

        $this->router->add('/getreport', function () {
            $ids = [29, 30, 32];
            $getReportNewsRequest = new GetReportNewsRequest($ids);
            // $this->newsController->getReport($getReportNewsRequest);
            print_r(($this->newsController->getReport($getReportNewsRequest))->link);
        });

        $this->router->dispatch($_SERVER['REQUEST_URI']);
    }
}
