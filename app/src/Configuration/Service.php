<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Configuration;

class Service
{
    /**
     * @return array
     */
    public static function getConfig(): array
    {
        $socketPathFiles = parse_ini_file(getcwd() . '/../config/socket.ini');

        return [
          'server_socket_file_path' => getcwd() . $socketPathFiles['server_socket_file_path'],
          'client_socket_file_path' => getcwd() . $socketPathFiles['client_socket_file_path'],
        ];
    }
}
