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
                $this->process($message);
            }
        }
    }

    public function process($message)
    {
        $arEmails = explode(";", $message);

        foreach ($arEmails as $email) {
            $email = trim($email);
            $result = Validator::validate($email);
            $this->composeResult($email, $result);
            
            print_r($this->composeResult($email, $result) . PHP_EOL);
        }
    }

    private function composeResult($email, $result)
    {
        $validMessage = "\033[32m valid \033[0m";
        $noValidMessage = "\033[31m not valid \033[0m";

        return $email . " - " . ($result ? $validMessage : $noValidMessage);
    }
}
