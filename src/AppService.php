<?php

declare(strict_types=1);

namespace hw6;

class AppService
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    public function validate(): string
    {
        $message = '';
        $string = $_SERVER["argv"][2] ?? '';

        try {
            if (empty($string)) {
                throw new InvalidParamException('Вы не ввели данные для валидации');
            }

            $data = explode(',', $string);
            foreach ($data as $value) {
                $result = $this->validator->validate($value)
                    ? 'Валидно'
                    : 'Невалидно';
                $message .= "$value - $result" . PHP_EOL;
            }
        } catch (\Throwable $exception) {
            $message = "Ошибка валидации: {$exception->getMessage()}" . PHP_EOL;
        }

        return $message;
    }
}
