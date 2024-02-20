<?php

namespace GoroshnikovP\Hw6;

use GoroshnikovP\Hw6\Chat\ChatClient;
use GoroshnikovP\Hw6\Chat\ChatServer;
use GoroshnikovP\Hw6\Dtos\PrepareResultDto;
use GoroshnikovP\Hw6\Dtos\SocketConfigDto;
use GoroshnikovP\Hw6\Dtos\ValidationDto;
use GoroshnikovP\Hw6\Enums\ModeEnum;
use GoroshnikovP\Hw6\Exceptions\PrepareException;
use GoroshnikovP\Hw6\Exceptions\RuntimeException;

class App
{
    private ModeEnum $mode;
    private SocketConfigDto $config;

    private function validation (): ValidationDto {
        // TODO: продумать валидацию. Как минимум, аргументы запуска. Наличие секций в кнофиг-файле.

        $result = new ValidationDto();
        $result->isValid = true;
        return $result;
    }

    private function prepareArg(): PrepareResultDto {
        $argc = $GLOBALS['argc'] ?? 0;
        $argv = $GLOBALS['argv'] ?? [];

        $res = new PrepareResultDto();

        if (3 === $argc && 'mode' === $argv[1]) {
            $mode = ModeEnum::tryFrom($argv[2]);
            if ($mode !== null) {
                $this->mode = $mode;
                $res->isOk = true;
                return $res;
            }
        }

        $res->isOk = false;
        $res->message = 'Скрипт должен быть запущен в cli, с параметрами "mode sever" или "mode client"';
        return $res;
    }

    private function prepare(): PrepareResultDto {
        $res = $this->prepareArg();
        if (!$res->isOk) {
            return $res;
        }

        if (!extension_loaded('sockets')) {
            $res->isOk = false;
            $res->message = 'Недоступно расширение sockets';
            return $res;
        }

        $this->prepareArg();

        $this->config = new SocketConfigDto();
        $this->config->fileNameServer = "/var/run/socket_chat_server.sock"; // TODO:
        $this->config->fileNameClient = "/var/run/socket_chat_client.sock"; // TODO:



        return $res;
    }

    /**
     * @throws PrepareException
     * @throws RuntimeException
     */
    public function run(): void {

        $prepareResult = $this->prepare();
        if (!$prepareResult->isOk) {
            throw new PrepareException('Ошибка подготовки:' . $prepareResult->message);
        }

        if (ModeEnum::Server === $this->mode) {
            $chat = new ChatServer($this->config);
        } elseif (ModeEnum::Client === $this->mode) {
            $chat = new ChatClient($this->config);
        }

        $chat->run();
        echo "\n";

    }
}
