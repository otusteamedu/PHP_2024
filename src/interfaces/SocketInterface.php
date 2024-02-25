<?php

namespace hw5\interfaces;

use \Socket;
use \Exception;

interface SocketInterface
{
    public function create(): Socket;

    /**
     * @param Socket $socket
     * @return void
     * @throws \Exception
     */
    public function bind(Socket $socket);

    /**
     * @param Socket $socket
     * @return void
     * @throws \Exception
     */
    public function listen(Socket $socket);

    public function acceptClient(Socket $socket): Socket;

    /**
     * @throws Exception
     */
    public function read(Socket $socket): string;

    /**
     * @param Socket $socket
     * @return void
     */
    public function closeClient(Socket $socket): void;

    /**
     * @param Socket $socket
     * @return void
     */
    public function close(Socket $socket): void;

    /**
     * @param Socket $socket
     * @param string $st
     * @return void
     */
    public function write(Socket $socket, string $st): void;

    /**
     * @param Socket $socket
     * @return void
     */
    public function connect(Socket $socket): void;

    /**
     * @param Socket $socket
     * @param string $buf
     * @return string
     * @throws Exception
     */
    public function recv(Socket $socket, string $buf);
}
