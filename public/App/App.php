<?php

namespace FTursunboy\App;

use FTursunboy\Validation\Validator;

class App
{
    public function run(): void
    {
        $emails = $_POST['emails'] ?? [];


        if (!Validator::validateEmails($emails)) {
            http_response_code(400);

            throw new \Exception("Bad request");
        }

        $this->successResponse();
    }

    private function successResponse(): void
    {
        http_response_code(200);

        echo "success";
    }
}
