<?php

declare(strict_types=1);

require_once "./vendor/autoload.php";

use RailMukhametshin\Hw\App\App;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    $formatter = new ConsoleOutputFormatter();
    $formatter->output($exception->getMessage(), ConsoleOutputFormatter::COLOR_RED);
}
