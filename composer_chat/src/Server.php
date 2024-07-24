<?php

namespace Chat\server;
use Chat\socket\UnixSocket as Socket;

class Server
{
    public $server;

    function __construct($host, $port, $maxlen)
    {
        if (file_exists($host)) {
            unlink($host);
        }
        $this->server = new Socket($host, $port, $maxlen);
    }

    function app()
    {
        $this->server->appServer();
        $this->server->readingMessages();
        $this->server->closeSession();
    }
}