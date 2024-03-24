<?php

namespace IraYu;

use IraYu\Contract;
use IraYu\Controller;

class App
{
    private string $config = __DIR__ . '/../config.ini';
    private array $options = [];

    private Controller\ChatController $frontController;
    private Contract\Request $request;

    protected function initConfigs(): static
    {
        if (!file_exists($this->config)) {
            throw new \ErrorException('Settings file does not exist.');
        }
        $this->options = parse_ini_file($this->config);
        $this->options['socket_dir'] = ($this->options['socket_dir'] ?? getenv('PWD'));

        if (!file_exists($this->options['socket_dir'])) {
            mkdir($this->options['socket_dir'], 0777, true);
        }

        $this->options['socket_path'] = $this->options['socket_dir'] . '/' . ($this->options['socket_file'] ?? 'chat.sock');

        return $this;
    }

    protected function initFrontController(): static
    {
        $this->frontController = new Controller\ChatController();
        $this->frontController->setConfigs($this->options)->init();

        return $this;
    }

    protected function initRequest()
    {
        if (defined('STDIN')) {
            $this->request = new Controller\CliRequest();
        } else {
            throw new \Exception('It is supposed to be a console application.');
        }

        return $this;
    }

    protected function start()
    {
        $this
            ->frontController
            ->setRequest($this->request)
            ->resolve()
        ;
    }

    public function run()
    {
        $this
            ->initConfigs()
            ->initFrontController()
            ->initRequest()
            ->start()
        ;
    }
}
