<?php

declare(strict_types=1);

require_once 'Validate.php';

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
            http_response_code(400);
            throw new Exception("Bad request");
        }

        http_response_code(200);

        echo "true";
    }
}
