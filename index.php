<?php
declare(strict_types=1);

use Crezi\Hw3ComposerPackages\CharToIntProcessor;

include __DIR__ . '/vendor/autoload.php';

$string = 'Hello world';

$numberString = new CharToIntProcessor();
$numberString = $numberString->getNumberString($string);

echo($numberString);