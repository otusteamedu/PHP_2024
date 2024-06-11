<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\UseCase;

use Kagirova\Hw21\Application\Controller\SubscribeController;
use Kagirova\Hw21\Application\Publisher\Publisher;
use Kagirova\Hw21\Application\Request\Request;
use Kagirova\Hw21\Application\Service\NotificationService;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class SubscribeToCategoryUseCase implements NewsUseCase
{
    public function __construct(
        private StorageInterface $storage,
        private Request $request,
        private Publisher $publisher
    ) {
    }

    public function run(): void
    {
        $categoryId = (int)$this->request->uri[1];
        $subscribeToCategoryController = new SubscribeController($this->storage, $categoryId);
        $subscribeToCategoryController->processRequest();

        $this->publisher->subscribe(new NotificationService(), $categoryId);
    }
}
