<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Controller;

use Kagirova\Hw21\Application\Response\Response;
use Kagirova\Hw21\Domain\Decorator\ReadingTimeInterface;
use Kagirova\Hw21\Domain\Decorator\ShareLinkInterface;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class GetNewsController implements NewsController
{
    public function __construct(
        private StorageInterface $storage,
        private array $uri
    ) {
    }

    public function processRequest(): void
    {
        if (isset($this->uri[1])) {
            $news = $this->storage->getNews($this->uri[1]);
            $readingTimeDecorator = new ReadingTimeInterface(new ShareLinkInterface($news));
            $response = $readingTimeDecorator->printNews();
        } else {
            $news = $this->storage->getAllNews();
            $response = [];
            foreach ($news as $newsJson) {
                array_push($response, $newsJson->printNews());
            }
        }
        Response::json($response, 200);
    }
}
