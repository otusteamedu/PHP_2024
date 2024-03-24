<?php
declare(strict_types=1);


//function getSocket() {
//    $path = '/tmp/phpsocket/socket.sock';
//    $socket = socket_create( AF_UNIX, SOCK_STREAM, 0 );
//    if ( $socket === FALSE ) {
//        throw new Exception(
//            "socket_create failed: reason: " . socket_strerror( socket_last_error() ));
//    }
//
//    $result = socket_connect($socket, $path);
//    if ($result === false) {
//        throw new Exception("socket_connect() failed.\nReason: ($result) " .
//            socket_strerror(socket_last_error($socket)));
//    }
//    return $socket;
//}
//
//function writeSocket($stmt) {
//    $tries = 0;
//    $socket = getSocket();
//    do {
//        // Is is possible that socket_write may not write the full $stmt?
//        // Do I need to keep rewriting until it's finished?
//        $writeResult = socket_write( $socket, $stmt, strlen( $stmt ) );
//        if ($writeResult === FALSE) {
//            // Got  a broken pipe, What's the best way to re-establish and
//            // try to write again, do I need to call socket_shutdown?
//            socket_close($socket);
//            $socket = getSocket();
//        }
//        $tries++;
//    } while ( $tries < MAX_SOCKET_TRIES && $writeResult ===  FALSE);
//}
//
//

$path = '/tmp/phpsocket/socket.sock';

if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
    echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
} else echo "Сокет создан\n";


echo "Пытаемся соединиться с socket: ... ";
$result = socket_connect($sock, $path);

if ($result === false) {
    echo "Не удалось выполнить socket_connect().\nПричина: " . socket_strerror(socket_last_error($sock)) . "\n";
} else {
    echo "OK.\n";
}
$read = socket_read($sock, 2048);
echo $read;

while (true) {

    $line = readline("Введите сообщение:  ");
    if ($line == '') continue;
    if (socket_write($sock, $line, strlen($line)) === false) {
        socket_close($sock);
        break;
    }

    $out = socket_read($sock, 2048);
    echo $out;

    if ($line === 'exit') {
        socket_close($sock);
        break;
    }
}
