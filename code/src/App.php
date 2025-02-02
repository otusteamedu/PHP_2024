<?php

declare(strict_types=1);

namespace DudkinIv\TestPackage;

use DudkinIv\TestPackage\Service\Routing;

class App
{
    protected Routing $routing;

    public function __construct()
    {
        $this->routing = new Routing();
    }

    public function run(): string
    {
        try {
            return $this->routing->handle();
        } catch (\Exception $exception) {
            http_response_code(500);

            return "Все совсем плохо!";
        }
    }
}
