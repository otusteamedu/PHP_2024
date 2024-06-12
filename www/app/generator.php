<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;

return function (\DI\ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \App\Infrastructure\ImageGenerator\BaseImageGenerator::class => function (\Psr\Container\ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $generationStrategy = $settings->get('generationStrategy');
            $yandexSettings = $settings->get('yandexArt');

            $publicPath = __DIR__ . '/../public';
            switch ($generationStrategy) {
                case 'mock':
                default:
                    return new \App\Infrastructure\ImageGenerator\MockGenerator($publicPath, '/static/images/mock');
                case 'yandexArt':
                    return new \App\Infrastructure\ImageGenerator\YandexArtGenerator(
                        $publicPath,
                        '/static/images/generated',
                        $yandexSettings['folder_id'],
                        $yandexSettings['yandex_oauth_token'],
                    );
            }
        }
    ]);
};
