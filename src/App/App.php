<?php

declare(strict_types=1);

namespace Komarov\Hw5\App;

use Komarov\Hw5\Exception\AppException;

class App
{
    /**
     * @throws AppException
     */
    public function run(): void
    {
        $emails = $_POST['emails'] ?? [];

        if (!Validator::validateEmails($emails)) {
            http_response_code(400);

            throw new AppException("Bad request");
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
