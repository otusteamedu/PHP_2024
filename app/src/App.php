<?php

namespace Evgenyart\EmailValidator;

use Exception;

class App
{
    const DEFAULTLIST = 'qwerty;evgeny@mail.ru; noisset@noissetdomaun.com;blalblala@ulo; почта@кто.рф';

    public function run()
    {
        while (1) {
            $message = trim(readline('Введите список email для валидации (разделитель `;`), `demo` для проверки списка по-умолчанию, `exit` для выхода: '));
            if (strlen($message)) {
                if ($message == 'exit') {
                    break;
                } elseif ($message == 'demo') {
                    $message = self::DEFAULTLIST;
                }
                $result = $this->process($message);
                $this->showResult($result);
            }
        }
    }

    public function process($message)
    {
        $message = trim($message);
        if (!strlen($message)) {
            throw new Exception('Empty email list.');
        }

        $result = [];
        $arEmails = explode(";", $message);

        foreach ($arEmails as $email) {
            $email = trim($email);
            $result[$email] = Validator::validate($email);
        }

        return $result;
    }

    private function showResult($resultCheck)
    {
        $validMessage = "\033[32m valid \033[0m";
        $noValidMessage = "\033[31m not valid \033[0m";

        foreach ($resultCheck as $email => $result) {
            print_r($email . " - " . ($result ? $validMessage : $noValidMessage) . PHP_EOL);
        }
    }
}
