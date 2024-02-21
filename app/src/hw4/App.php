<?php

namespace Akornienko\App\hw4;

class App
{
    public function run(): void {
        echo "Запрос обработал контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL;
        $this->validateSequences();
    }
    private function validateSequences(): void {
        $bracketsSequence = '';
        if (array_key_exists('string', $_POST)) {
            $bracketsSequence = $_POST['string'];
        }
        $bracketsValidator = new BracketsValidator();
        $isValidSequence = $bracketsValidator->validate($bracketsSequence);

        if (!$isValidSequence) {
            http_response_code(400);
            print_r("Invalid brackets sequence\n");
        }
    }
}