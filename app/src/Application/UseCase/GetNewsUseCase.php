<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\UseCase;

use Kagirova\Hw21\Application\Controller\GetNewsController;
use Kagirova\Hw21\Application\Request\Request;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class GetNewsUseCase implements NewsUseCase
{
    public function __construct(
        private StorageInterface $storage,
        private Request $request
    ) {
    }

    public function run(): void
    {
        $getNewsController = new GetNewsController($this->storage, $this->request->uri);
        $getNewsController->processRequest();
    }
}
