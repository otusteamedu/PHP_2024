<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\DTO\Chat;

use Kiryao\Sockchat\Helpers\DTO\DTOInterface;

class Config implements DTOInterface
{
    public function __construct(
        private string $server_run,
        private string $client_run,
        private string $chat_exit
    ) {
    }

    public function getServerRun(): string
    {
        return $this->server_run;
    }

    public function getClientRun(): string
    {
        return $this->client_run;
    }

    public function getChatExit(): string
    {
        return $this->chat_exit;
    }
}
