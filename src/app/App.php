<?php

declare(strict_types=1);

namespace Igor\ValidateBrackets;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): string
    {
        if (empty($_REQUEST["string"])) {
            throw new Exception("Не верный параметр string");
        }
        $string = $_REQUEST["string"];

        if (Validate::isBracketsValidate($string)) {
            return "Строка валидная";
        }

        return "Не верный формат строки";

    }
}
