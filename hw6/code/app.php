<?php

declare(strict_types=1);

require_once "vendor/autoload.php";
use GoroshnikovP\Hw6\App;
try {
    $app = new App();
    echo $app->run();
} catch (Throwable $ex) {
// иными словами, код построен так, что все исключения должны быть отловлены в коде App. Если тут сработало,
    // то значит упустили отлов в коде.
    echo "Пропустили экзепшен(((\n";
    print_r($ex);
}
