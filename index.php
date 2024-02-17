<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use JackFrost\GuessNumber\GuessNumber;

$game = new GuessNumber();

echo $game->check(5);
