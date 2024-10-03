<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Config;

class Config
{
    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../../app.ini', true);
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app.ini file');
        }

    }

}
