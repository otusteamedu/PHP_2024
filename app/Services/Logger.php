<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\LogLevelEnum;
use Exception;

class Logger
{
    private const FILE_PATH = __DIR__ . '/../logs/host_metrics_app.log';

    /**
     * @throws Exception
     */
    public function __construct(private readonly LogLevelEnum $level, private readonly string|array $message)
    {
        $this->writeLog();
    }

    /**
     * @throws Exception
     */
    private function writeLog(): void
    {
        $log = [
            'time' => date('d/m/y H:i', time()),
            'level' => $this->level->value,
            'message' => $this->message
        ];

        file_put_contents(self::FILE_PATH, json_encode($log) . PHP_EOL, FILE_APPEND) or throw new Exception('log err');
    }
}