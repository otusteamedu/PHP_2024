<?php
declare(strict_types=1);

set_time_limit(0);
ob_implicit_flush();

if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
    echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
}

