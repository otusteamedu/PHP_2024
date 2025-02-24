<?php

declare(strict_types=1);

namespace Otus\Hw16;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{services}.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/routes.yaml');
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    public function registerBundles(): iterable
    {
        $bundles = [
            new FrameworkBundle()
        ];

        return $bundles;
    }
}
