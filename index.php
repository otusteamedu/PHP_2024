<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use KirillGubenko\DirectoryReader\DirectoryReader;

$directoryReader = new DirectoryReader();
print_r($directoryReader->getFiles(__DIR__));
