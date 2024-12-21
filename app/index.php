<?php

declare(strict_types=1);
error_reporting(E_ALL);
mb_internal_encoding("UTF-8");

require 'autoload.php';

echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
