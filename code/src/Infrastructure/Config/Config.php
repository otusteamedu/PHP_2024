<?php
declare(strict_types=1);

namespace App\Infrastructure\Config;

class Config
{
    const CONFIG_PATH = __DIR__.'/config.ini';
    const SOCKET_PATH = 'SOCKET_PATH';
    const SOCK_CONST_SECTION = 'Socket_constants';
    private ?string $socket_path = '';
    private ?array $socket_const = [];

    public function __construct()
    {
        $config = parse_ini_file(self::CONFIG_PATH,true);
        $this->socket_path = $config[self::SOCKET_PATH];
        $this->socket_const = $config[self::SOCK_CONST_SECTION];
    }

    public function getSocketPath() {
        try {
            return $this->socket_path;
        } catch (\Exception $e) {
            echo "Fatal error: ".$e->getMessage();
        }
    }

    public function getSockConst() {
        return $this->socket_const;
    }

}