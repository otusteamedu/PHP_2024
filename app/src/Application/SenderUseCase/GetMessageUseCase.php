<?php

declare(strict_types=1);

namespace Hinoho\Battleship\Application\SenderUseCase;

use Hinoho\Battleship\Domain\RepositoryInterface\StorageInterface;
use Hinoho\Battleship\Domain\Request;
use Hinoho\Battleship\Domain\Response;

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
