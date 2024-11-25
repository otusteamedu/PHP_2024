<?php

use Andryjka\Otus\SpaceChecker;

require __DIR__ . '/../vendor/autoload.php';

$spaceChecker = new SpaceChecker();

echo $spaceChecker->checkSpace();