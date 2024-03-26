<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw14\App;

try {
    $shortopts = 'q:g:l:c:s:';
    $longopts = [
      'query:',
      'gte:',
      'lte:',
      'category:',
      'shop:',
    ];
    $options = getopt($shortopts, $longopts);
    (new App($options))
        ->run();
} catch (Exception $e) {
    echo 'Error: ==========================================';
    echo PHP_EOL;
    echo $e->getMessage();
    echo PHP_EOL;
}
