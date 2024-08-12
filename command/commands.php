<?php

use App\Command\CommandInterface;
use App\Command\RequestProcessCommand;
use App\Provider\PostgresProvider;
use App\Queue\Handler\RequestProcessHandler;
use App\Queue\Queue;
use App\Repository\RequestProcessRepository;

require_once __DIR__ . "/../vendor/autoload.php";

$commands = [
    'app:request:process' => new RequestProcessCommand(
        new Queue(),
        new RequestProcessHandler(
            new RequestProcessRepository(new PostgresProvider())
        )
    )
];

$commandName = $argv[1] ?? null;
if (!$commandName || empty($commands[$commandName])) {
    echo "Команда не определена";
    exit();
}

/** @var CommandInterface $command */
$command = $commands[$commandName];
$command->execute();


