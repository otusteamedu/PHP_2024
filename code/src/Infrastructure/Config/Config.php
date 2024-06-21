<?php
declare(strict_types=1);

namespace App\Infrastructure\Config;

class Config
{
    private const CONFIG_PATH = __DIR__.'/config.ini';
    private array $config;

    public readonly string $envCookingStepsPath;
    public readonly string $prepareDoughBaseStep;
    public readonly string $addIngrediancesStep;
    public readonly string $heatUpStep;
    public readonly string $productReadyStep;

    public function __construct()
    {
        $this->config = parse_ini_file(self::CONFIG_PATH,true);
        $this->envCookingStepsPath = getenv("SOURCE_USECASE_COOKING_STEPS_PATH");
        $this->prepareDoughBaseStep = $this->config['Cooking_steps']['STEP_1'];
        $this->addIngrediancesStep = $this->config['Cooking_steps']['STEP_2'];
        $this->heatUpStep = $this->config['Cooking_steps']['STEP_3'];
        $this->productReadyStep = $this->config['Cooking_steps']['STEP_4'];
    }
}