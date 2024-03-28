<?php

declare(strict_types=1);

namespace App\Base;

readonly class Config
{
    public string $elasticHost;
    public string $elasticPassword;
    public array $indexSettings;
    public string $logPath;

    public function __construct(array $settings, array $env)
    {
        $this->elasticHost = $env['ELASTIC_HOST'];
        $this->elasticPassword = $env['ELASTIC_PASSWD'];
        $this->indexSettings = $settings['elasticsearch']['indexSettings'];
        $this->logPath = $settings['elasticsearch']['logPath'];
    }
}
