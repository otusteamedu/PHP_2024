<?php

namespace SlavaMakhov\OtusQueueApp\Services;

interface QueueInterface
{
    /**
     * Метод отправляет сообщение в очередь
     *
     * @param array $data
     *
     * @return void
     */
    public function sendMessage(array $data): void;

    /**
     * Метод получает сообщения из очереди
     *
     * @param callable $callback
     *
     * @return void
     */
    public function consumeMessages(callable $callback): void;
}
