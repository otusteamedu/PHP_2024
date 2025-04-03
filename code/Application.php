<?php

declare(strict_types=1);

use Asyrovatkin\Hw15\Main;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

require_once __DIR__ .'/vendor/autoload.php';
class Application extends CLI
{
    const PARAMETER_FULL_PATH = 'path';
    const PARAMETER_FULL_SHOW_HTML = 'html';
    const PARAMETER_FULL_SHOW_TXT = 'txt';

    protected function setup(Options $options): void
    {
        $options->setHelp('Сканирование указанной директории');
        $options->registerOption(
            self::PARAMETER_FULL_PATH,
            'Путь по которому провести сканирование',
            null,
            true
        );
        $options->registerOption(
            self::PARAMETER_FULL_SHOW_HTML,
            'Показывать html (1 - да)'
        );
        $options->registerOption(
            self::PARAMETER_FULL_SHOW_TXT,
            'Показывать txt (1 - да)'
        );
    }

    protected function main(Options $options): void
    {
        $path = $options->getOpt(self::PARAMETER_FULL_PATH);
        $extensionsToPrint = [];
        if ($options->getOpt(self::PARAMETER_FULL_SHOW_HTML) == 1) $extensionsToPrint[] = 'html';
        if ($options->getOpt(self::PARAMETER_FULL_SHOW_TXT) == 1) $extensionsToPrint[] = 'txt';

        try {
            $main = new Main();
            $main->process($path, $extensionsToPrint);
        } catch (Exception $exception) {
            echo $exception->getMessage() . "\n";
        }
    }
}

(new Application())->run();