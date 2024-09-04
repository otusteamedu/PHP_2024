<?php

declare(strict_types=1);

namespace Session;

function startSession(): void
{
    session_start([
        'save_handler' => 'redis',
        'save_path' => "tcp://{$_ENV['REDIS_HOST']}:6379?auth={$_ENV['REDIS_PASSWORD']}"
    ]);
}

function incrementCounter(): void
{
    $count = getCounterValue();

    $_SESSION['counter'] = ++$count;
}

function getCounterValue(): int
{
    return $_SESSION['counter'] ?? 1;
}
