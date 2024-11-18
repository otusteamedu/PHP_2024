<?php

declare(strict_types=1);

namespace App\Application\Generator\Console;

use App\Domain\Exception\SocketException;
use App\Domain\Service\ClientService;
use Generator;

class ClientGenerator
{
    public function __construct(
        private $inputStream,
        private $outputStream
    ) {
    }

    /**
     * @return Generator
     * @throws SocketException
     */
    public function run(): Generator
    {
        $clientService = new ClientService($this->inputStream, $this->outputStream);
        yield $clientService->initializeChat();

        foreach ($clientService->keepChat() as $post) {
            yield $post;
        }

        foreach ($clientService->stopChat() as $post) {
            yield $post;
        }
    }
}
