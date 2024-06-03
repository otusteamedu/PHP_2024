<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Service\MessageProcess;

use AlexanderGladkov\Broker\Exchange\ProducerInterface;

class MessageProcessService
{
    public function __construct(private ProducerInterface $producer)
    {
    }

    /**
     * @throws ValidationException
     */
    public function process(MessageProcessRequest $request): void
    {
        $errors = $request->validate();
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $message = json_encode($request->toArray());
        $this->producer->publish($message);
    }
}
