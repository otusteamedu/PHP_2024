<?php

declare(strict_types=1);

include 'vendor/autoload.php';

use Smolyaninov\OtusComposerPackage\StringProcessor;

$stringProcessor = new StringProcessor();

echo $stringProcessor->getLength('hello') . PHP_EOL;