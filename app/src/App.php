<?php

declare(strict_types=1);

namespace IgorKachko\CheckEmail;

use IgorKachko\CheckEmail\Controllers\CheckEmailController;

class App
{
    public function run(): void {
        if($_SERVER['argc'] !== 2) {
            throw new \Exception("Нужно обязательно указать один email");
        }

        $email = $_SERVER['argv'][1];
        $controller = new CheckEmailController();
        $controller($email);
    }
}