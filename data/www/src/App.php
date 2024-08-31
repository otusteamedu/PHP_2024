<?php

namespace HW4;

include_once __DIR__ . '/Checker.php';

use HW4\Checker;

class App
{
    public $protocol = 'HTTP/1.1';
    public $code = 200;
    public $message = 'It`s OK';

    public function run(): void
    {
        $checker = new Checker();
        if (
            !isset($_POST["string"])
            || $checker->isEmpty($_POST["string"])
            || !$checker->isCorrect($_POST["string"])
        ) {
            $this->code = 400;
            $this->message = 'Bad Request';
        }

        header($this->protocol . ' ' . $this->code . ' ' . $this->message);
        return;
    }
}
