<?php

declare(strict_types=1);

use NikolayShvetsov\RenameService\RenameFile;

require __DIR__ . '/vendor/autoload.php';

$rename = new RenameFile();

echo $rename->getNewTitle('file-name.csv');
