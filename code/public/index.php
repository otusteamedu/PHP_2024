<?php

declare(strict_types=1);

use Afilippov\Hw4\app\Checker;
use Afilippov\Hw4\app\Form;

require_once "../../vendor/autoload.php";

try {
    $form = new Form($_POST);
    $checker = new Checker();
    if ($checker->check($form->inputString)) {
        echo "Параметр `string` содержит корректное количество открытых и закрытых скобок.";
    } else {
        echo "В параметре `string` открытые и закрытые скобки не валидны.";
    }
} catch (Throwable $exception) {
    echo $exception->getMessage();
}
