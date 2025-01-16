<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusVerificationEmailApp;

class App
{
    protected EmailValidate $emailValidate;

    public function __construct()
    {
        $this->emailValidate = new EmailValidate();
    }

    /**
     * Запуск приложения
     *
     * @return string
     * @throws CheckEmailsException
     */
    public function run(): string
    {
        $message = '';

        if (!isset($_POST['emails'])) {
            throw new CheckEmailsException();
        }

        $emails = $_POST['emails'];

        foreach ($emails as $email) {
            $checkEmailResult = $this->emailValidate->run(trim($email));

            $message .= $email . ' - ' . $checkEmailResult . PHP_EOL;
        }

        return $message;
    }
}
