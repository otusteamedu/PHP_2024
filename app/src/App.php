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
     * @return void
     * @throws CheckEmailsException
     */
    public function run(): void
    {
        if (!isset($_POST['emails'])) {
            throw new CheckEmailsException();
        }

        $emails = $_POST['emails'];

        foreach ($emails as $email) {
            $checkEmailResult = $this->emailValidate->run($email);

            echo $email . ' - ' . $checkEmailResult . PHP_EOL;
        }
    }

}