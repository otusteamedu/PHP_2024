<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Domain\Exception\Validate\TitleValidateException;
use App\Domain\Exception\Validate\UrlValidateException;
use App\Application\UseCase\CreateNews;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\NewsRepository;
use App\Infrastructure\Service\PageTitleParser;
use DateTimeImmutable;

class CreateNewsController extends Controller
{
    public function __construct(private readonly PageTitleParser $pageTitleParser)
    {
        parent::__construct();
    }

    /**
     * @throws UrlValidateException
     * @throws TitleValidateException
     */
    public function createNews(...$params): string
    {
        $url = $params['url'] ?? '';
        $title = $this->pageTitleParser->parsePageTitle($url);
        $connection = Connection::getInstance();
        $repository = new NewsRepository($connection);
        $newsRequest = new CreateNewsRequest(
            (new DateTimeImmutable())->format('Y-m-d'),
            $title,
            $url
        );
        $useCase = new CreateNews($repository);
        $response = $useCase($newsRequest);

        return json_encode(['id' => $response->id]);
    }
}
