<?php

include __DIR__ . '/vendor/autoload.php';

use Aevkiselev\ExampleLibrary\Sender;

$sender = new Sender();

if ($sender->send())
{
	echo 'Done!';
}
