<?php

declare(strict_types=1);

require('vendor/autoload.php');

use Dsergei\Hw5\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}

/*$some_state = 'initial';

function gen() {
    global $some_state;

    echo "gen() execution start\n";
    $some_state = "changed";

    yield 1;
    yield 2;
}

function peek_state() {
    global $some_state;
    echo "\$some_state = $some_state\n";
}

echo "calling gen()...\n";
$result = gen();
echo "gen() was called\n";

peek_state();

echo "iterating...\n";
foreach ($result as $val) {
    echo "iteration: $val\n";
    peek_state();
}*/
