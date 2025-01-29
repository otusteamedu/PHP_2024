<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Infrastructure\Factory\CommonNewsFactory;
use Anatolyshilyaev\Hw14\Infrastructure\Http\NewsController;
use Anatolyshilyaev\Hw14\Infrastructure\Repository\DBNewsRepository;

class App
{
    public function __construct()
    {
        try {
            $url = "https://lenta.ru/news/2025/01/28/chatgpt-otreagiroval-na-perevod-strelok-chasov-sudnogo-dnya-k-yadernoy-polunochi/";

            $CreateNewsRequest = new CreateNewsRequest($url);

            $CommonNewsFactory = new CommonNewsFactory();
            $DBNewsRepository = new DBNewsRepository();
            $newsUseCase = new CreateNewsUseCase($CommonNewsFactory, $DBNewsRepository);

            $NewsController = new NewsController($newsUseCase);
            print_r($NewsController($CreateNewsRequest)->id);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }
}
