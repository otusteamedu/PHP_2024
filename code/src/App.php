<?php

declare(strict_types=1);

namespace TimurShakirov\EmailValidator;

use Exception;
use TimurShakirov\EmailValidator\EmailValidator;

class App
{
    /**
     * @throws Exception
     */
    private function getEmailFromFile($filename)
    {
        try {
            if (!file_exists($filename)) {
                throw new Exception("Нет файла" . $filename);
            }
            $file = fopen($filename, 'r');
            while (!feof($file)) {
                yield fgets($file);
            }
            fclose($file);
        } catch (Exception $e) {
            throw new Exception("Ошибка в получении email: " . PHP_EOL . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function run($filename): void
    {
        try {
            $validator = new EmailValidator();
            foreach ($this->getEmailFromFile($filename) as $email) {
                if (!$email) {
                    echo 'Email адресов нет';
                    break;
                }
                $email = trim($email);
                $result = (bool)$validator->validateEmail($email) ? 'correct' : 'incorrect';
                echo "{$email} is {$result} \n";
            }
        } catch (Exception $e) {
            throw new Exception("Ошибка в валидаторе: " . PHP_EOL . $e->getMessage() . PHP_EOL);
        }
    }
}
