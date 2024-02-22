<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6;

use Exception;
use GoroshnikovP\Hw6\Chat\ChatClient;
use GoroshnikovP\Hw6\Chat\ChatServer;
use GoroshnikovP\Hw6\Enums\ModeEnum;
use GoroshnikovP\Hw6\Exceptions\PrepareException;
use GoroshnikovP\Hw6\Exceptions\RuntimeException;

class App
{
    const CONFIG_PATH = 'config.ini';
    private ModeEnum $mode;
    private string $socketFile;


    /**
* @return string расшифровка ошибки. Пустая строка - нет ошибки.
     */
    private function prepareArg(): string
    {
        $argc = $GLOBALS['argc'] ?? 0;
        $argv = $GLOBALS['argv'] ?? [];
        if (3 !== $argc || !in_array($argv[1], ['-m', '--mode'])) {
            return 'Скрипт должен быть запущен в cli, с параметрами "--mode sever" или "--mode client" или ключом "-m".';
        }

        try {
            $this->mode = ModeEnum::From($argv[2]);
        } catch (Exception) {
            return 'Не распознан режим работы чата (клиент/сервер).';
        }

        return '';
    }


    /**
     * @return string расшифровка ошибки. Пустая строка - нет ошибки.
     */
    private function prepareConfig(): string
    {
        if (!file_exists(static::CONFIG_PATH)) {
            return 'Не найден файл конфигурации, ' . static::CONFIG_PATH;
        }

        $arrConfig = parse_ini_file(static::CONFIG_PATH, false);
        $this->socketFile = $arrConfig['socket_file_name'] ?? '';

        if (empty($this->socketFile)) {
            return 'Ошибка в синтаксисе конфига' . static::CONFIG_PATH;
        }

        return '';
    }


    private function prepare(): string
    {
        $res = $this->prepareArg();
        if (!empty($res)) {
            return $res;
        }

        if (!extension_loaded('sockets')) {
            return 'Недоступно расширение sockets';
        }

        return $this->prepareConfig();
    }

    public function run(): string
    {
        try {
            $prepareResult = $this->prepare();
            if (!empty($prepareResult)) {
                throw new PrepareException('Ошибка подготовки:' . $prepareResult);
            }

            if (ModeEnum::Server === $this->mode) {
                $chat = new ChatServer($this->socketFile);
            } elseif (ModeEnum::Client === $this->mode) {
                $chat = new ChatClient($this->socketFile);
            }

            $chat->run();
        } catch (PrepareException $ex) {
            return "Проблема при старте: {$ex->getMessage()}";
        } catch (RuntimeException $ex) {
            echo "Проблема при выполнении: {$ex->getMessage()}";
        }

        return '';
    }
}
