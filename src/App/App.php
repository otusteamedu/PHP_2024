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
            http_response_code(400);

            throw new Exception("Bad request");
        }

        $this->successResponse();
    }

    /**
     * @return void
     */
    private function successResponse(): void
    {
        http_response_code(200);

        echo "Success request";
    }
}
