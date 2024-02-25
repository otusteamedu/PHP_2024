<?php

namespace Pavelsergeevich\Hw5;

class App implements Runnable
{
    /**
     * @var $appName string|mixed Название приложения, пример: 'server'
     */
    public string $appName;

    /**
     * @var $appClassName string Класс приложения, пример: 'Pavelsergeevich\Hw5\ServerApp'
     */
    public string $appClassName;

    /**
     * @var $app Runnable Экземпляр ServerApp или ClientApp
     */
    public Runnable $app;
    public function __construct()
    {
        $this->appName = $_SERVER['argv'][1];

        if ($this->appName !== 'server' && $this->appName !== 'client') {
            throw new \Exception('Необходимо передать первым аргументом название приложения (\'server\' или \'client\')');
        }

        $this->appClassName = match ($this->appName) {
            'client' => 'Pavelsergeevich\\Hw5\\ClientApp',
            'server' => 'Pavelsergeevich\\Hw5\\ServerApp',
        };

        if (!class_exists($this->appClassName)) {
            throw new \Exception('Не обнаружено приложение: ' . $this->appClassName);
        }
    }

    public function run(): void
    {
        $this->app = new $this->appClassName;
        $this->app->run();
    }
}