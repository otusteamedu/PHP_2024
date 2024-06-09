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

        return json_encode((new GetNews($repository))());
    }
}
