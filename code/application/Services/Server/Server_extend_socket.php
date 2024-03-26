<?php
declare(strict_types=1);
namespace App\Services\Server;

use App\Services\Socket\Socket;

class ServerExtendsocket extends Socket
{
    const CLOSE_CONN = 'exit';

    public function __construct() {
        $this->create();
        $this->bind();
        $this->listen();
    }

    public function accept()
    {
        parent::accept();
    }

    public function read()
    {
        parent::read();
    }

    public function write(string $msg): bool
    {
        return parent::write($msg);
    }

    public function closeServer()
    {
        parent::close();
    }

    public function closeAcceptedConn(string|null $msg): bool
    {
        if ($msg === self::CLOSE_CONN) {
            parent::closeAcceptedCon();
            return true;
        }
        return false;
    }
}