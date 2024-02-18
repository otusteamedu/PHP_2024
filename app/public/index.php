<?php

declare(strict_types=1);

use Rmulyukov\Hw4\BracesChecker;
use Rmulyukov\Hw4\Request;
use Rmulyukov\Hw4\Response;

require_once "../vendor/autoload.php";

$string = (new Request())->get('string');
$isCorrectString = (new BracesChecker())->check($string);
echo (new Response($isCorrectString))->send();
