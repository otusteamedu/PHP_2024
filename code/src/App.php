<?php

declare(strict_types=1);

namespace Naimushina\Verificator;

use Exception;

class App
{
    /**
     * Запуск приложения
     * @throws Exception
     */
    public function run(): \Generator
    {
        yield 'Приложение проверки email адресов.' . PHP_EOL;
        yield 'Введите email адреса через запятую' . PHP_EOL;

        $input = trim(fgets(STDIN));
        $verificator = new EmailVerificator();
        $emails = explode(',', $input);

        foreach ($emails as $email) {
            if (!$email) {
                break;
            }

            $correctFormat = $verificator->checkByRegEx($email);


            yield "адрес $email" . PHP_EOL;
            yield $this->showResult($correctFormat, 'Валидация по регулярным выражениям');
            if ($correctFormat) {
                $dnsCorrect = $verificator->checkByDns($email);
                yield $this->showResult($dnsCorrect, 'Проверка DNS mx записи');
            }
        }
    }


    /**
     * Вывод информации о результатах проверки
     * @param bool $result
     * @param string $checkType
     * @return string
     */
    private function showResult(bool $result, string $checkType): string
    {
        $message = $result ? ' пройдена успешно' : ' не пройдена';
        return $checkType . $message . PHP_EOL;
    }
}
