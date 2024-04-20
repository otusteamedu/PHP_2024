<?php

declare(strict_types=1);

namespace AShutov\Hw14;

readonly class Config
{
    public string $elasticHost;
    public string $elasticPassword;
    public string $elasticUser;
    public array $indexSettings;
    public string $elasticIndex;

    public function __construct(array $settings, array $env)
    {
        $this->elasticHost = $env['ELASTIC_HOST'];
        $this->elasticPassword = $env['ELASTIC_PASSWORD'];
        $this->elasticUser = $env['ELASTIC_USER'];
        $this->elasticIndex = $env['ELASTIC_INDEX'];
        $this->indexSettings = $settings['elasticsearch'];
    }
}
