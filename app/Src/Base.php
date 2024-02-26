<?php

declare(strict_types=1);

namespace App;

class Base
{
    public object $result;

    /**
     * @return object|bool|null
     * @throws SocketErrorException
     */
    public function run(): object|bool|null
    {
        if (in_array('server', $_SERVER['argv'])) {
            $server = new Server();
            $this->result = $server->createServer();
            foreach ($this->result as $item) {
                print_r($item);
            }
        }
        if (in_array('client', $_SERVER['argv'])) {
            if (file_exists(__DIR__ . Base::getConfig('server_side_sock'))) {
                $client = new Client();
                $this->result = $client->createClient();
                foreach ($this->result as $item) {
                    print_r($item);
                }
            } else {
                $this->getBaseError('Attention!!! You mast not start client before server');
            }
        }
        return $this->result;
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
