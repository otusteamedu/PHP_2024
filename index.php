<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

\App\HomeWork\TestPsr::echoHelloWorld();

use Kynchevich\OtusTestPackage\OtusTest;

$otusTest = new OtusTest();

echo "<br>";
echo "<br>";
echo "<br>";

$otusTest->helloWorld();
