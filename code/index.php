<?php

declare(strict_types=1);

use Viking311\Builder\SelectBuilder\SelectBuilder;

require 'vendor/autoload.php';

$dsn = 'pgsql:host=postgres_db;port=5432;dbname=postgres;user=postgres;password=mysecretpassword';

$pdo = new PDO($dsn);

$builder = new SelectBuilder($pdo);

$r = $builder
    ->from('(select * from test)')
    ->orderBy('id', 'desc')
    ->where('id', '2')
    ->execute();
foreach($r as $rr) {
    var_dump($rr);
}