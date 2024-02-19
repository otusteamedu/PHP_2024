<?php
declare(strict_types=1);

namespace Hukimato\SocketChat;

abstract class SocketClient
{
    /**
     * @var string|null Имя по которому приложение будет идетифицироваться при общении с сервером
     */
    protected ?string $name = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    protected static function getSocketNameFromServerName(string $serverName): string
    {
        return "/sockets/{$serverName}.sock";
    }
}