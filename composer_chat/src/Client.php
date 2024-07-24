<?php

namespace Chat\client;
use Chat\socket\UnixSocket as Socket;

class Client
{
    public $client;

    function __construct($host, $port, $maxlen)
    {
        $this->client = new Socket($host, $port, $maxlen);
    }

    function app()
    {
        $this->client->appClient();
        $this->client->sendingMessages();
        $this->client->closeSession();
    }
}
