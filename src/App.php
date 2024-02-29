<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\InvalidAppTypeException;
use Alogachev\Homework\Exception\WrongInputException;

final class App
{
    private const ALLOWED_APP_TYPES = [
        'client',
        'server',
    ];

    public function run(): void
    {
        $config = Config::getInstance()->getConfig();
        $appType = $this->resolveAppType();

        echo "\nВсе хорошо. Работаем!";
    }

    private function resolveAppType(): string
    {
        if ($_SERVER['argc'] !== 2) {
            throw new WrongInputException();
        }
        $appType = strtolower(trim($_SERVER['argv'][1]));

        if (!in_array($appType, self::ALLOWED_APP_TYPES)) {
            throw new InvalidAppTypeException($appType);
        }

        return $appType;
    }
}
