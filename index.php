<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use SlavaMakhov\OtusComposerApp\Infrastructure\StringCommand;

$command = new StringCommand();
$command->run();