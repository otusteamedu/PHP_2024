<?php
declare(strict_types=1);

namespace App\Infrastructure\Config;

class Config
{
    private const CONFIG_PATH = __DIR__.'/config.ini';
    private array $config;
    private const COOKING_STEPS = 'Cooking_steps';

    public readonly array $cookingSteps;

    public function __construct()
    {
        $this->config = parse_ini_file(self::CONFIG_PATH,true);
        $this->cookingSteps = $this->config[self::COOKING_STEPS];
    }
}