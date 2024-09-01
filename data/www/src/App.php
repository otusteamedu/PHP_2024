<?php

namespace HW4;

class App
{
    public function run(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["string"])) {
                $stringHandler = new StringHandler();
                $stringHandler->run($_POST["string"]);
            }
        }
    }
}
