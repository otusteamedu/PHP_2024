<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Application\SenderUseCase;

use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw31\Domain\Request;
use Kagirova\Hw31\Domain\Response;

class GetMessageUseCase
{
    public function __construct(
        private StorageInterface $storage,
        private Request $request
    ) {
    }

    public function run()
    {
        $status = $this->storage->getStatus($this->request->uri[1]);
        Response::json(["status" => $status]);
    }
}
