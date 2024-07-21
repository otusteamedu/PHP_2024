<?php

namespace App\old\Infrastructure\Main;

interface ApplicationInterface
{
    public function __construct(array $config);

    public static function setInstance(self $application): void;

    public static function initApplication(array $config): self;

    public static function getInstance(): self;
}
