<?php

namespace script\class;

class Server
{
    public static function startServer()
    {
        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            die('Unable to create AF_UNIX socket');
        }
        $server_side_sock = dirname(__FILE__) . "/server.sock";
        if (!socket_bind($socket, $server_side_sock)) {
            die("Unable to bind to $server_side_sock");
        }
        while (1) {
            if (!socket_set_block($socket)) {
                die('Unable to set blocking mode for socket');
            }
            $buf = '';
            $from = '';
            $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
            if ($bytes_received == -1) {
                die('An error occurred while receiving from the socket');
            }
            echo $buf;
        }
    }
}
