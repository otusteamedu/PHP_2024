<?php

declare(strict_types=1);

namespace App;

class ServerApp implements AppInterface
{
    private \Socket $socket;
    private MessageEncoderInterface $messageEncoder;

    /**
     * @throws DomainException
     */
    public function __construct(string $server_address, MessageEncoderInterface $messageEncoder)
    {
        if (file_exists($server_address)) {
            unlink($server_address);
        }

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new DomainException('Не удалось создать сокет - ' . socket_strerror(socket_last_error()));
        }
        $this->socket = $socket;
        if (!socket_bind($this->socket, $server_address)) {
            throw new DomainException(
                'Не удалось привязаться к сокету - ' . socket_strerror(socket_last_error())
            );
        }

        if (!socket_listen($this->socket)) {
            throw new DomainException(
                'Не удалось слушать сокет - ' . socket_strerror(socket_last_error())
            );
        }

        $this->messageEncoder = $messageEncoder;
    }

    public function run(): void
    {
        echo "Сервер запущен\n";
        $isRunning = true;
        $clients = [$this->socket];

        while ($isRunning) {
            $read_sockets = $clients;
            $write = $except = null;

            if (socket_select($read_sockets, $write, $except, 0)) {
                if (in_array($this->socket, $read_sockets)) {
                    $newClient = socket_accept($this->socket);
                    $welcomeMsg = $this->messageEncoder->encode('Добро пожаловать в чат');
                    socket_write($newClient, $welcomeMsg);
                    $key = array_search($this->socket, $read_sockets);
                    unset($read_sockets[$key]);
                    $clients[] = $newClient;
                    echo "Подключен новый клиент\n";
                }

                foreach ($read_sockets as $key => $value) {
                    $data = socket_read($value, 1024);
                    if ($data) {
                        echo "Клиент написал: " . $this->messageEncoder->decode($data);
                        $confirmationMsg = $this->messageEncoder->encode('Получено ' . strlen($data) . ' байт.');
                        socket_write($value, $confirmationMsg);
                    } elseif ($data == '') {
                        echo "Клиент отключился.\n";
                        unset($clients[$key]);
                        socket_close($value);
                    }
                }
            }

            if ($input = ConsoleHelper::getNotBlockingInputFromSTDIN()) {
                $msg = $this->messageEncoder->encode($input);
                foreach ($clients as $con) {
                    if ($con != $this->socket) {
                        socket_write($con, $msg, strlen($msg));
                    }
                }
            }
        }
    }
}
