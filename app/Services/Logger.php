<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\LogLevelEnum;
use Exception;

class Logger
{
    protected static Logger|null $instance = null;

    /**
     * @throws Exception
     */
    protected function __construct()
    {
    }

    public function writeLog(LogLevelEnum $level, string|array $message, string $outputPath): void
    {
        $log = [
            'time' => date('d/m/y H:i', time()),
            'level' => $level,
            'message' => $message
        ];

        file_put_contents(
            $outputPath,
            json_encode($log) . PHP_EOL,
            FILE_APPEND
        );
    }

    public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }
}
