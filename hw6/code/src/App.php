<?php
declare(strict_types=1);

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
    const CONFIG_PATH = 'config.ini';
    private ModeEnum $mode;
    private SocketConfigDto $socketConfig;

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

        if (3 === $argc && in_array($argv[1], ['-m', '--mode'])) {
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


    private function prepareConfig(): PrepareResultDto {
        $res = new PrepareResultDto();

        if (!file_exists(static::CONFIG_PATH)) {
            $res->isOk = false;
            $res->message = 'Не найден файл конфигурации, ' . static::CONFIG_PATH;
            return $res;
        }

        $arrConfig = parse_ini_file(static::CONFIG_PATH, false);

        $this->socketConfig = new SocketConfigDto();
        $this->socketConfig->fileNameServer = $arrConfig['file_name_server'] ?? '';
        $this->socketConfig->fileNameClient = $arrConfig['file_name_client'] ?? '';

        if ($this->socketConfig->fileNameServer && $this->socketConfig->fileNameClient) {
            $res->isOk = true;
        } else {
            $res->isOk = false;
            $res->message = 'Ошибка в синтаксисе конфига' . static::CONFIG_PATH;
        }

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

        $res = $this->prepareConfig();
        if (!$res->isOk) {
            return $res;
        }

        return $res;
    }

    public function run(): void {
        try {
            $prepareResult = $this->prepare();
            if (!$prepareResult->isOk) {
                throw new PrepareException('Ошибка подготовки:' . $prepareResult->message);
            }

            if (ModeEnum::Server === $this->mode) {
                $chat = new ChatServer($this->socketConfig);
            } elseif (ModeEnum::Client === $this->mode) {
                $chat = new ChatClient($this->socketConfig);
            }

            $chat->run();
        } catch(PrepareException $ex){
            echo "Проблема при старте: \n";
            print_r([
                'message' =>  $ex->getMessage(),
                'code' =>  $ex->getCode(),
                'file' =>  $ex->getFile(),
                'line' =>  $ex->getLine(),
            ]);
        } catch(RuntimeException $ex){
            echo "Проблема при выполнении: \n";
            print_r([
                'message' =>  $ex->getMessage(),
                'code' =>  $ex->getCode(),
                'file' =>  $ex->getFile(),
                'line' =>  $ex->getLine(),
            ]);
        }


    }
}
