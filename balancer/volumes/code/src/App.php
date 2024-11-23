<?php

declare(strict_types=1);

namespace RShevtsov\Hw4;

class App
{
    public function run(): string
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return (new StringChecker())->check($_POST['string'] ?? '');
        } else {
            return '<b>Session counter:</b> ' . session_id() ;
        }
    }
}
