<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Hukimato\EsApp\App;

// php app.php --title="Давокин" --category="Детская литература" --min-price=2000 --max-price=2500

try {
    $app = new App();
    $app->run();
} catch (\Throwable $e) {
    print "Не удается инициализировать прилоежние." . PHP_EOL;
    print $e->getMessage() . PHP_EOL;
}
