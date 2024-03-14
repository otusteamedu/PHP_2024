<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];


try {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=example', 'root', '1q2w3e4r5t');
    echo "Postgres is running" . "<br/>";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}