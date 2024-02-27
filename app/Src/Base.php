<?php

declare(strict_types=1);

namespace App;

class Base
{
    /**
     * @return void
     * @throws SocketErrorException
     */
    public function run(): void
    {
        if (in_array('server', $_SERVER['argv'])) {
            $server = new SocketStart();
            $server->startServerSocket();
        }
        if (in_array('client', $_SERVER['argv'])) {
            if (file_exists(__DIR__ . Base::getConfig('server_side_sock'))) {
                $server = new SocketStart();
                $server->startClientSocket();
            } else {
                $this->getBaseError('Attention!!! You mast not start client before server');
            }
        }
    }

    /**
     * @param string $string
     * @return string|object
     * @throws SocketErrorException
     */
    public static function getConfig(string $string): string|object
    {
        $path = dirname(dirname(__FILE__));
        $ini_array = parse_ini_file($path . "/config.ini");
        if (array_key_exists($string, $ini_array)) {
            return $ini_array[$string];
        } else {
            throw new SocketErrorException("Undefined '$string' in " . __DIR__ . "/config.ini");
        }
    }

    /**
     * @param string $message
     * @return object
     * @throws SocketErrorException
     */
    public function getBaseError(string $message): object
    {
        throw new SocketErrorException($message);
    }
}
