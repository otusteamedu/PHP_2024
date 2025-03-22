<?php

use ValentinFilshin\OtusComposerPackage\StringProcessor;

require_once __DIR__ . '/vendor/autoload.php';

$stringProcessor = new StringProcessor();
echo $stringProcessor->getLength('Hello world');
