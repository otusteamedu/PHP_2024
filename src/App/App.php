<?php

declare(strict_types=1);

namespace VSukhov\Validator\App;

use VSukhov\Validator\Exception\AppException;

class App
{
    /**
     * @throws AppException
     */
    public function run(): void
    {
        $emails = $_POST['emails'] ?? [];

        if (!Validator::validate($emails)) {
            http_response_code(400);

            throw new AppException("Validator error");
        }

        $this->successResponse();
    }

    private function successResponse(): void
    {
        http_response_code(200);

        echo "Validator success";
    }
}
