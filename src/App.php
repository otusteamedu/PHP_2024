<?php

namespace PenguinAstronaut\App;

use Exception;

class App
{
    public function run(): void
    {
        $emailList = [
            'chack.k@mail.ru',
            'penguin2804@gmail.com',
            'test@test.com',
        ];

        $validator = new EmailValidator();

        foreach ($emailList as $email) {
            try {
                if ($validator->validate($email)) {
                    echo 'Valid: ' . $email . PHP_EOL;
                }
            } catch (Exception $e) {
                echo 'Invalid: ' . $email . PHP_EOL;
            }
        }
    }
}
