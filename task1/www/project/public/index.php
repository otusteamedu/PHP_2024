<?php
declare(strict_types=1);

use App\Exceptions\StringValidException;
use App\Services\StringService;

require __DIR__.'/../vendor/autoload.php';

$stringValidator = new StringService($_POST['string']);

try {
    header('HTTP/1.1' . 200);
    echo $stringValidator->validete();
} catch(StringValidException $e) {
    header('HTTP/1.1' . 422);
    echo $e->getErrorMessage();
}