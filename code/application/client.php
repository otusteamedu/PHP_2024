<?php
declare(strict_types=1);

$path = '/tmp/phpsocket/socket.sock';
$AF_UNIX = AF_UNIX;
if (($sock = socket_create($AF_UNIX, SOCK_STREAM, 0)) === false) {
    echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
} else echo "Сокет создан\n";


echo "Пытаемся соединиться с socket: ... ";
$result = socket_connect($sock, $path);

if ($result === false) {
    echo "Не удалось выполнить socket_connect().".PHP_EOL."Причина: " . socket_strerror(socket_last_error($sock)) .PHP_EOL;
} else {
    echo "OK.".PHP_EOL;
}
$read = socket_read($sock, 2048);
echo $read;

while (true) {

    if (!socket_getpeername($sock, $AF_UNIX)) break;

    $line = readline(PHP_EOL."Введите сообщение:  ");
    if ($line == '') continue;
    if (socket_write($sock, $line, strlen($line)) === false) {
        socket_close($sock);
        break;
    }

    $out = socket_read($sock, 2048);

    echo PHP_EOL.$out.PHP_EOL;

    if ($line === 'exit') {
        //socket_close($sock);
        break;
    }
}
socket_close($sock);