<?php

declare(strict_types=1);

namespace  ChatOtus\App;

use ErrorException;

class Server implements SocketChat
{
    /**
     * @param string $socketPath
     * @throws ErrorException
     */
    public function run(string $socketPath)
    {
        if (file_exists($socketPath)) {
            unlink($socketPath);
        }

        $server = stream_socket_server("unix://$socketPath", $errno, $errstr);
        if (!$server) {
            throw new ErrorException($errstr, $errno);
        }

        echo "Server started, waiting for connections...\n";

        while ($conn = stream_socket_accept($server)) {
            $message = fread($conn, 1024);
            echo "Received message: $message\n";
            $response = "Received " . strlen($message) . " bytes";
            fwrite($conn, $response);
            fclose($conn);
        }

        fclose($server);
    }
}