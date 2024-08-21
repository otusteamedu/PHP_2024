<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use PenguinAstronaut\App\Exceptions\EmptyStringException;
use PenguinAstronaut\App\Exceptions\InvalidStringException;
use PenguinAstronaut\App\Validator;


try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $validator = new Validator();
        $validator->validateString($_POST['string'] ?? '');
    }
} catch (EmptyStringException | InvalidStringException $e) {
    http_response_code(400);
}
