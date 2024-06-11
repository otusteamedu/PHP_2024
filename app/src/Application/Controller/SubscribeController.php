<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Controller;

use Kagirova\Hw21\Application\Response\Response;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class SubscribeController implements NewsController
{
    public function __construct(
        private StorageInterface $storage,
        private int $categoryId
    ) {
    }

    public function processRequest(): void
    {
        $this->storage->subscribeToNews($this->categoryId);
        Response::json(array("Result" => 'OK'), 200);
    }
}
