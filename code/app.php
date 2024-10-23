<?php

declare(strict_types=1);

foreach (glob("./src/*.php") as $filename) {
    include_once $filename;
};

use Kyberlox\Elastic\app\App as App;

$app = new App();
$app->run($argv);

//php app.php 'рыцОри' 'Исторический роман' 2000 1
