<?php

namespace SergeyShirykalov\EmailValidator;

class App
{
    public static function run(): string
    {
        $emails = $_REQUEST['emails'] ?? null;

        $response[] = '<h3>Проверка валидности email</h3>';

        if (empty($emails)) {
            $response[] = '<b>Необходимо указать параметр emails - массив email для проверки!</b><br>';
        } else {
            foreach ($emails as $email) {
                $isValid = Validator::isValid($email);
                $response[] = 'email ' . $email . ($isValid ? ' корректен' : ' некорректен');
            }
        }

        return Response::response(implode('<br>', $response));
    }
}
