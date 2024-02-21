<?php

declare(strict_types=1);

use App\Exceptions\StringValidException;
use App\Services\StringService;

require __DIR__. '/../vendor/autoload.php';

$stringValidator = new StringService($_POST['string']);

try {
    echo $stringValidator->validete();
} catch (StringValidException $e) {
    echo $e->getErrorMessage();
}
