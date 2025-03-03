<?php

namespace App;

use App\Application\UseCase\CreateRequest\CreateRequestUseCase;
use App\Domain\Factory\RequestFactoryInterface;
use App\Domain\Repository\RequestRepositoryInterface;
use App\Infrastructure\Controller\CreateRequestController;
use App\Infrastructure\Factory\RequestFactory;
use App\Infrastructure\Repositories\RequestOrmRepository;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;
use Nelmio\ApiDocBundle\NelmioApiDocBundle;
use OldSound\RabbitMqBundle\DependencyInjection\Compiler\RegisterPartsPass;
use OldSound\RabbitMqBundle\DependencyInjection\OldSoundRabbitMqExtension;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->registerExtension(new OldSoundRabbitMqExtension());
        $containerBuilder->addCompilerPass(new RegisterPartsPass());
    }
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {

        /*// Set required parameters
        $container->setParameter('kernel.secret', $_ENV['APP_SECRET'] ?? 'fallback_secret');*/

        // Register extensions for Doctrine and Nelmio API Doc
        $container->registerExtension(new DoctrineExtension());
        $container->registerExtension(new \Nelmio\ApiDocBundle\DependencyInjection\NelmioApiDocExtension());

        // 🔹 Explicitly load existing YAML config files
        $configDir = $this->getProjectDir() . '/config/packages';

        if (file_exists($configDir . '/doctrine.yaml')) {
            $loader->load($configDir . '/doctrine.yaml');
        }

        if (file_exists($configDir . '/nelmio_api_doc.yaml')) {
            $loader->load($configDir . '/nelmio_api_doc.yaml');
        }
        if (file_exists($configDir . '/old_sound_rabbit_mq.yaml')) {
            $loader->load($configDir . '/old_sound_rabbit_mq.yaml');
        }

        if (file_exists($configDir . '/framework.yaml')) {
            $loader->load($configDir . '/framework.yaml');
        }
        if (file_exists($configDir . '/doctrine_migrations.yaml')) {
            $loader->load($configDir . '/doctrine_migrations.yaml');
        }

        if (file_exists($this->getProjectDir() . '/config/services.yaml')) {
            $loader->load($this->getProjectDir() . '/config/services.yaml');
        }

        // 🔹 Register services automatically
        $container
            ->registerForAutoconfiguration(CreateRequestUseCase::class)
            ->setPublic(true);

        $container
            ->setAlias(RequestFactoryInterface::class, RequestFactory::class);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        // Load routes from the controllers directory
        $routes->import('../src/Infrastructure/Controller/', 'attribute');
        $routes->import($this->getProjectDir() . '/config/routes/nelmio_api_doc.yaml');

        // Load standard routes.yaml configuration
        $routes->import($this->getProjectDir() . '/config/routes.yaml');
    }
}
