<?php

declare(strict_types=1);

require_once "vendor/autoload.php";
use GoroshnikovP\Hw7\App;
use GoroshnikovP\Hw7\Exception\AppException;

try {
    $app = new App();
    $result = $app->run();
    echo "--------\n";
    foreach ($result as $item) {
        echo ($item ? '+' : '-') . "\n";
    }
    echo "--------\n";
} catch (AppException $ex) {
    echo "Ошибка: {$ex->getMessage()} \n";
    echo "file: {$ex->getFile()} \n";
    echo "line: {$ex->getLine()} \n";
} catch (Throwable $ex) {
// иными словами, код построен так, что все исключения должны быть отловлены в коде App. Если тут сработало,
    // то значит упустили отлов в коде.
    echo "Пропустили экзепшен(((\n";
    print_r($ex);
}
