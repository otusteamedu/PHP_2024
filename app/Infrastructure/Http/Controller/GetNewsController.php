<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetNews;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\NewsRepository;

class GetNewsController extends Controller
{
    public function getNews(): string
    {
        $connection = Connection::getInstance();
        $repository = new NewsRepository($connection);
        $useCase = new GetNews($repository);

        return json_encode(array_map(static fn ($news) => [
            'id' => $news->getId(),
            'title' => $news->getTitle(),
            'url' => $news->getUrl(),
            'date' => $news->getDate(),
        ], $useCase()));
    }
}
