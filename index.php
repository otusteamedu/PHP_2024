<?php

require 'vendor/autoload.php';

use KirillGubenko\DirectoryReader\Factory\DirectoryReaderFactory;

$directoryReader = DirectoryReaderFactory::create();

$catalog = __DIR__;

print_r($directoryReader->getFiles($catalog));

print_r($directoryReader->getFilesWithInfo($catalog));
