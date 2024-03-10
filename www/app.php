<?php

require __DIR__ . '/vendor/autoload.php';

try
{
	$app = new Otus\Application();
	$app->run();
}
catch (Exception $e)
{
	echo $e->getMessage() . PHP_EOL;
}
