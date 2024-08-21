<?php

declare(strict_types=1);

namespace Komarov\Hw4;

use Exception;

class App
{
    private Validate $validate;

    public function __construct()
    {
        $this->validate = new Validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        if (!$this->validate->checkStringBrackets()) {
            throw new Exception("Bad request", 400);
        }

        throw new Exception("Success request", 200);
    }
}
