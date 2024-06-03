<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Controller;

use Kagirova\Hw21\Application\Response\Response;
use Kagirova\Hw21\Domain\Builder\NewsBuilder;
use Kagirova\Hw21\Domain\Entity\News;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class AddNewsController implements NewsController
{
    private ?News $news = null;

    public function __construct(
        private StorageInterface $storage,
        private array $input
    ) {
    }

    public function processRequest(): void
    {
        $categoryId = $this->storage->getCategoryId($this->input['category']);
        if ($categoryId === -1) {
            $categoryId = $this->storage->addCategory($this->input['category']);
        }
        $newsBuilder = (new NewsBuilder())
            ->setName($this->input['name'])
            ->setDate($this->input['date'])
            ->setAuthor($this->input['author'])
            ->setCategory($categoryId, $this->input['category'])
            ->setText($this->input['text']);

        $this->news = $newsBuilder->build();
        $newsId = $this->storage->saveNews($this->news);
        $this->news->setId($newsId);

        Response::json(array("newsID" => $newsId), 201);
    }

    public function getNews()
    {
        return $this->news;
    }
}
