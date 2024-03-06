<?php

declare(strict_types=1);

namespace App;

readonly class ConsoleApp implements AppInterface
{
    public function __construct(private array $args = [])
    {
    }


    /**
     * @throws DomainException
     */
    public function run(): \Iterator
    {
        $appType = $this->args[1] ?? '';
        $server_address = (string) getenv('SERVER_ADDRESS');
        $messageEncoder = new Base64MessageEncoder();

        $app = match ($appType) {
            AppType::server->name => new ServerApp($server_address, $messageEncoder),
            AppType::client->name => new ClientApp($server_address, $messageEncoder),
            default => throw new DomainException('Указан недопустимый тип приложения')
        };

        return $app->run();
    }
}
