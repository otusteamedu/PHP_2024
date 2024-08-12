<?php
use App\Provider\PostgresProvider;

require_once __DIR__ . "/../vendor/autoload.php";

$databaseProvider = new PostgresProvider();

(new \App\Migration\CreateRequestProcessTableMigration($databaseProvider))->up();
