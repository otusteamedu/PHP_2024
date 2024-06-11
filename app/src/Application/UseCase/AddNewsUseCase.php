<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\UseCase;

use Kagirova\Hw21\Application\Controller\AddNewsController;
use Kagirova\Hw21\Application\Publisher\Publisher;
use Kagirova\Hw21\Application\Request\Request;
use Kagirova\Hw21\Domain\Event\NewsIsCreatedEvent;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class AddNewsUseCase implements NewsUseCase
{
    public function __construct(
        private StorageInterface $storage,
        private Request $request,
        private Publisher $publisher
    ) {
    }

    public function run(): void
    {
        $addNewsController = new AddNewsController($this->storage, $this->request->data);
        $news = $addNewsController->processRequest();
        $event = new NewsIsCreatedEvent($news->getId(), $news->getCategory());

        $this->publisher->notify($event);
    }
}
