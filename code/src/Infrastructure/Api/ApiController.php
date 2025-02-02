<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Infrastructure\Api;

use Asyrovatkin\Hw14\Aplication\UseCase\AskNewsList\AskNewsList;
use Asyrovatkin\Hw14\Aplication\UseCase\CreateNewsReport\CreateReport;
use Asyrovatkin\Hw14\Aplication\UseCase\SubmitNews\SubmitNewsRequest;
use Asyrovatkin\Hw14\Aplication\UseCase\SubmitNews\SubmitNewsUseCase;
use Asyrovatkin\Hw14\Infrastructure\Factory\CommonNewsFactory;
use Asyrovatkin\Hw14\Infrastructure\Repository\PostgresqlNewsRepository;
use Asyrovatkin\Hw14\Infrastructure\WebParser\WebParser;
use http\Exception\InvalidArgumentException;

class ApiController
{
    public function addNews(): bool|string
    {
        $url = $_POST['url'];
        $submitNewsRequest = new SubmitNewsRequest($url);
        $submitNewsUseCase = new SubmitNewsUseCase(
            new CommonNewsFactory(),
            new PostgresqlNewsRepository(),
            new WebParser()
        );
        $submitNewsResponse = $submitNewsUseCase($submitNewsRequest);
        $news = $submitNewsResponse->getNews();
        return json_encode(['id' => $news->getId()]);
    }

    public function getNewsList(): string
    {
        $askNewsList = new AskNewsList(new PostgresqlNewsRepository());
        $newsList = $askNewsList();
        return (string)$newsList;
    }

    public function createNewsReport(): bool|string
    {
        $jsonIds = $_POST['ids'];
        $ids = json_decode($jsonIds);
        if (!is_array($ids) || empty($ids)) {
            throw new InvalidArgumentException('ids must be an array');
        }

        $createReport = new CreateReport(new PostgresqlNewsRepository());
        $fileName = $createReport->process($ids);
        return json_encode(['report_link' => $fileName], JSON_UNESCAPED_SLASHES);
    }
}