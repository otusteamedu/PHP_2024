<?php

namespace Naimushina\Webservers;

class Response
{
    /**
     * @param $status
     * @param $message
     * @return void
     */
    public function send($status, $message)
    {
        header('HTTP/1.1 ' . $status);
        echo $message;
    }
}
