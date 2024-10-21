<?php

declare(strict_types=1);

namespace Otus\App\EmailChecker;

class EmailChecker
{
    private EmailValidator $emailValidator;
    private Response $response;

    public function __construct()
    {
        $this->emailValidator = new EmailValidator();
        $this->response = new Response();
    }

    public function run(): void
    {
        $emails = $_POST['emails'] ? explode(",", $_POST['emails']) : [];
        $this->check($emails);
    }

    public function check(array $emails = []): void
    {
        if (!count($emails)) {
            $this->response->error("NOTHING TO CHECK");
            return;
        }

        foreach ($emails as $email) {
            $isValid = $this->emailValidator->validate(trim($email));
            if ($isValid) {
                $this->response->success($email . ': VALID<br>');
            } else {
                $this->response->error($email . ': INVALID<br>');
            }
        }
    }
}
