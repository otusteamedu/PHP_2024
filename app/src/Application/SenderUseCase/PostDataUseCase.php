<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Application\SenderUseCase;

use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw31\Domain\Request;
use Kagirova\Hw31\Domain\Response;
use Kagirova\Hw31\Infrastucture\Service\RabbitMqService;

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
