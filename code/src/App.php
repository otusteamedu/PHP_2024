<?php

declare(strict_types=1);

namespace PavelMiasnov\VerificationEmailPhp;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): \Generator
    {
        yield 'Приложение проверки email адресов.' . PHP_EOL;
        yield 'Введите email адреса через запятую' . PHP_EOL;

        $input = trim(fgets(STDIN));
        $verification = new Verification();
        $emails = explode(',', $input);

        foreach ($emails as $email) {
            if (!$email) {
                break;
            } else {
                $email = trim($email);
            }

            $correctFormat = $verification->checkByDefault(trim($email));


            yield "Email адрес - $email" . PHP_EOL;
            yield $this->printResult($correctFormat, 'Базовая проверка');
            if ($correctFormat) {
                $dnsCorrect = $verification->checkByDns($email);
                yield $this->printResult($dnsCorrect, 'Проверка DNS mx записи');
                if ($dnsCorrect) {
                    yield "Email соответствует правилам" . PHP_EOL;
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    public function printResult($result, $checkType): string
    {
        $message = $result ? ' пройдена' : ' не пройдена';
        return $checkType . $message . PHP_EOL;
    }
}
