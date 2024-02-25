<?php

declare(strict_types=1);


namespace hw5;

use hw5\interfaces\SocketInterface;
use \Socket;
use \Exception;

final class UnixSocket implements SocketInterface
{
    private const DOMAIN = AF_UNIX;
    private const TYPE = SOCK_STREAM;
    private const LENGTH = 2048;
    private const FLAG = MSG_WAITALL;


    public function __construct(
        private File $file
    ) {
    }

    /**
     * @return Socket
     * @throws \Exception
     */
    public function create(): Socket
    {
        if (!$socket = socket_create(self::DOMAIN, self::TYPE, 0)) {
            $this->error("Не удалось создать сокет");
        }

        return $socket;
    }

    /**
     * @param Socket $socket
     * @return void
     * @throws \Exception
     */
    public function bind(Socket $socket)
    {
        if (socket_bind($socket, $this->file->getFilePath()) === false) {
            $this->error("Не удалось привязать имя к сокету");
        }
    }

    /**
     * @param Socket $socket
     * @return void
     * @throws \Exception
     */
    public function listen(Socket $socket)
    {
        if (!socket_listen($socket)) {
            $this->error("Не удалось прослушать сокет");
        }
    }

    public function acceptClient(Socket $socket): Socket
    {
        if (!$client = socket_accept($socket)) {
            $this->error("Не удалось принять соединение на сокете");
        }

        return $client;
    }

    /**
     * @throws Exception
     */
    public function read(Socket $socket): string
    {
        if (!$message = socket_read($socket, self::LENGTH)) {
            $this->error("Не удалось прочитать строку");
        }
        return $message;
    }

    /**
     * @param Socket $socket
     * @return void
     */
    public function closeClient(Socket $socket): void
    {
        socket_close($socket);
    }

    /**
     * @param Socket $socket
     * @return void
     */
    public function close(Socket $socket): void
    {
        socket_close($socket);
    }

    public function write(Socket $socket, string $st): void
    {
        if (!socket_write($socket, $st, strlen($st))) {
            $this->error("Не удалось запись в сокет");
        }
    }

    public function connect(Socket $socket): void
    {
        if (!socket_connect($socket, $this->file->getFilePath())) {
            $this->error("Не удалось начать соединение с сокетом");
        }
    }

    /**
     * @param Socket $socket
     * @param string $buf
     * @return string
     * @throws Exception
     */
    public function recv(Socket $socket, string $buf)
    {
        if (!socket_recv($socket, $buf, self::LENGTH, self::FLAG)) {
            $this->error("Не удалось получить данные из подсоединённого сокета");
        }

        return $buf;
    }

    /**
     * @param string $text
     * @return void
     * @throws \Exception
     */
    private function error(string $text): void
    {
        $code = socket_last_error();
        $msg = socket_strerror($code);

        throw new \Exception("$text: [$code] - $msg");
    }
}
