<?php

declare(strict_types=1);

namespace Valen\App;

use Exception;
use Dotenv\Dotenv;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Valen\App\Application\Youtube\UseCase\Channel\DeleteChannelUseCase;
use Valen\App\Application\Youtube\UseCase\Channel\AddChannelUseCase;
use Valen\App\Domain\Youtube\Channel;
use Valen\App\Infrastructure\OpenSearch\OpenSearchClient;
use Valen\App\Infrastructure\Youtube\Mapper\ChannelMapper;
use Valen\App\Infrastructure\Youtube\Repository\ChannelRepository;

class App
{
    private ContainerBuilder $container;

    public function run(): void
    {
        $this->loadEnv();
        $this->loadDI();

        $channelArray = [
            'channelId' => 'UC-lHJZR3Gqxm24_Vd_AJ5Yw',
            'title' => 'Test',
            'description' => 'Test',
            'subscriberCount' => 10000,
            'videoCount' => 200,
            'publishedAt' => '2020-10-10'
        ];

        $channel = Channel::createFromArray($channelArray);

        echo '<pre>';

        try {
            $addChannelUseCase = $this->container->get('addChannelUseCase');
            $addChannelUseCase->execute($channel);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $deleteChannelUseCase = $this->container->get('deleteChannelUseCase');
            $deleteChannelUseCase->execute($channel->getChannelId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        echo 123;

        echo '</pre>';
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
        $container->register('channelMapper', ChannelMapper::class);
        $container->register('channelRepository', ChannelRepository::class)
            ->addArgument(new Reference('openSearchClient'))
            ->addArgument(new Reference('channelMapper'));

        $container->register('addChannelUseCase', AddChannelUseCase::class)
            ->addArgument(new Reference('channelRepository'));
        $container->register('deleteChannelUseCase', DeleteChannelUseCase::class)
            ->addArgument(new Reference('channelRepository'));

        $this->container = $container;
    }
}
