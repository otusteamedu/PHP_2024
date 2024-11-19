<?php

namespace App\Controller\Console;

use App\Application\Generator\Console\ClientGenerator;
use App\Application\Generator\Console\ServerGenerator;
use App\Domain\Enum\ServiceCommand;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Exception\SocketException;
use App\Domain\Service\ConfigService;

class Controller
{
    private $inputStream;
    private $outputServerStream;
    private $outputClientStream;

    public function __construct()
    {
        $config = ConfigService::class;
        $this->inputStream = fopen($config::get('INPUT_STREAM'), 'r');
        $this->outputServerStream = fopen($config::get('OUTPUT_SERVER_STREAM'), 'w');
        $this->outputClientStream = fopen($config::get('OUTPUT_CLIENT_STREAM'), 'w');
    }

    public function run(array $argv): void
    {
        try {
            if (in_array(ServiceCommand::ServerStart->value, $argv)) {
                foreach ((new ServerGenerator())->run() as $message) {
                    fwrite($this->outputServerStream, $message);
                }
            } elseif (in_array(ServiceCommand::ClientStart->value, $argv)) {
                foreach ((new ClientGenerator($this->inputStream, $this->outputClientStream))->run() as $message) {
                    fwrite($this->outputClientStream, $message);
                }
            } else {
                fwrite($this->outputServerStream, ServiceMessage::Default->value);
            }
        } catch (SocketException $e) {
            fwrite($this->outputServerStream, 'Error: ' . $e->getMessage() . PHP_EOL);
        }
    }

    public function setInputStream($stream): void
    {
        $this->inputStream = $stream;
    }

    public function setOutputServerStream($stream): void
    {
        $this->outputServerStream = $stream;
    }

    public function setOutputClientStream($stream): void
    {
        $this->outputClientStream = $stream;
    }
}
