<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw6;

class App
{
    public function run()
    {
        echo $this->handleRequest();
    }

    private function handleRequest(): string
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!is_array($_POST['emails'])) {
                throw new \InvalidArgumentException('Emails parameter should be an array');
            }

            $validEmails = [];

            foreach ($_POST['emails'] as $email) {
                if (EmailValidator::validate($email)) {
                    $validEmails[] = $email;
                }
            }

            $response = ['message' => 'OK', 'valid_emails' => $validEmails];
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            $response = ['message' => $e->getMessage()];
        }

        return json_encode($response);
    }
}
