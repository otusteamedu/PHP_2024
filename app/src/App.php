<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14;

use Anatolyshilyaev\Hw14\Infrastructure\NewsParser\NewsParser;
use Anatolyshilyaev\Hw14\Infrastructure\ReportGenerator\ReportGenerator;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsUseCase;
use Anatolyshilyaev\Hw14\Infrastructure\Factory\NewsFactory;
use Anatolyshilyaev\Hw14\Infrastructure\Http\CreateNewsController;
use Anatolyshilyaev\Hw14\Infrastructure\Http\FindAllNewsController;
use Anatolyshilyaev\Hw14\Infrastructure\Http\GetReportNewsController;
use Anatolyshilyaev\Hw14\Infrastructure\Repository\NewsRepository;

class App
{
    private Router $router;

    private NewsFactory $newsFactory;
    private NewsParser $newsParser;
    private NewsRepository $newsRepository;
    private ReportGenerator $reportGenerator;

    private CreateNewsUseCase $createNews;
    private FindAllNewsUseCase $findAllNews;
    private GetReportNewsUseCase $getReportNews;

    private CreateNewsController $createNewsController;
    private FindAllNewsController $findAllNewsController;
    private getReportNewsController $getReportNewsController;

    public function __construct()
    {
        $this->router = new Router();

        $this->newsParser = new NewsParser();
        $this->reportGenerator = new ReportGenerator();
        $this->newsFactory = new NewsFactory();
        $this->newsRepository = new NewsRepository();

        $this->createNews = new CreateNewsUseCase($this->newsFactory, $this->newsParser, $this->newsRepository);
        $this->findAllNews = new FindAllNewsUseCase($this->newsFactory, $this->newsRepository);
        $this->getReportNews = new GetReportNewsUseCase($this->newsRepository, $this->reportGenerator);

        $this->createNewsController = new CreateNewsController($this->createNews);
        $this->findAllNewsController = new FindAllNewsController($this->findAllNews);
        $this->getReportNewsController = new getReportNewsController($this->getReportNews);
    }

    public function __invoke(): void
    {
        $this->router->add('/create', function () {
            $url = "https://saint-art.net/vozvrashhenie-shedevrovdva-korolevskih-konnyh-portreta-diego-velaskesa-vernulis-v-muzej-prado-posle-restavraczii/";
            $createNewsRequest = new CreateNewsRequest($url);
            $newsId = $this->createNewsController->create($createNewsRequest)->id;
            print_r($newsId);
            return $newsId;
        });

        $this->router->add('/findall', function () {
            $allNews = $this->findAllNewsController->findAll();
            print_r($allNews);
            return $allNews;
        });

        $this->router->add('/getreport', function () {
            $ids = [1, 3, 7];
            $getReportNewsRequest = new GetReportNewsRequest($ids);
            $link = ($this->getReportNewsController->getReport($getReportNewsRequest))->filename;
            print_r($link);
            return $link;
        });

        $this->router->dispatch($_SERVER['REQUEST_URI']);
    }
}
