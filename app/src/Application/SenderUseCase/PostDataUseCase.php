<?php

declare(strict_types=1);

namespace Hinoho\Battleship\Application\SenderUseCase;

use Hinoho\Battleship\Domain\RepositoryInterface\StorageInterface;
use Hinoho\Battleship\Domain\Request;
use Hinoho\Battleship\Domain\Response;
use Hinoho\Battleship\Infrastucture\Service\RabbitMqService;

class PostDataUseCase
{
    public function __construct(
        private RabbitMqService $service,
        private StorageInterface $storage,
        private Request $request
    ) {
    }

    public function run()
    {
        $data = $this->getData();

        $messageId = $this->storage->addMessage($data);
        $this->service->publish($data, $messageId);
        $this->storage->updateStatus($messageId, 2);
        Response::json(["message_id" => $messageId]);
    }

    private function getData()
    {
        if (!isset($this->request->data['data'])) {
            throw new \Exception('', 404);
        }
        return $this->request->data['data'];
    }
}
