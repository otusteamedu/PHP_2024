<?php

declare(strict_types=1);

namespace App\src\Socket;

use App\src\Contracts\ProcessInterface;
use App\src\Enums\ProcessEnum;
use Exception;

class SocketProcessesResolver
{
    public ProcessInterface $process;
    public string $socketPath;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->loadSocketPath();
    }

    /**
     * @throws Exception
     */
    public function runProcess(): void
    {
        $argStart = $this->getArgs();
        $processClass = ProcessEnum::from($argStart)->resolveProcessClass();
        $this->process = new $processClass($this->socketPath);
        $this->process->run();
    }

    /**
     * @throws Exception
     */
    private function getArgs(): string
    {
        if (empty($_SERVER['argv'][1])) {
            throw new Exception('Not arg process type!');
        }

        return $_SERVER['argv'][1];
    }

    /**
     * @throws Exception
     */
    private function loadSocketPath(): void
    {
        $env = parse_ini_file(dirname(__DIR__) . '/../../.env');

        if (!$env) {
            throw new Exception('Not found env file!');
        }

        if (empty($env['SOCKET_PATH'])) {
            throw new Exception('Empty SOCKET_PATH!');
        }

        $this->socketPath = $env['SOCKET_PATH'];
    }
}
