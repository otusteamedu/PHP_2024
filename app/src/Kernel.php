<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        // Загружаем конфигурационные файлы из директории config
        $loader->import($this->getProjectDir() . '/config/packages/framework.yaml');
        $loader->import($this->getProjectDir() . '/config/services.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        // Загружаем маршруты из файла routes.yaml
        $routes->import($this->getProjectDir() . '/config/routes.yaml');
    }
}
