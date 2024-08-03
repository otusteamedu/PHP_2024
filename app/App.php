<?php

namespace App;

use App\Components\Elastic\ElasticComponent;

class App
{
    public static self $instance;

    readonly public ElasticComponent $elasticComponent;

    public function __construct()
    {
        $this->registerComponents();

        static::$instance = $this;
    }

    public function run(...$params): void
    {
//        var_dump($this->elasticComponent->client->ping());
    }

    protected function registerComponents(): void
    {
        $this->elasticComponent = new ElasticComponent();
    }
}