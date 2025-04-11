<?php

declare(strict_types=1);

namespace Valen\App;

use Dotenv\Dotenv;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
class App
{
    private ContainerBuilder $container;

    public function run(): void
    {
        $this->loadEnv();
        $this->loadDI();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 123;
        }
    }

    private function loadEnv(): void
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    private function loadDI(): void
    {
        $container = new ContainerBuilder();
        $container->register('openSearchClient', OpenSearchClient::class);

        $this->container = $container;
    }
}
