<?php

declare(strict_types=1);

namespace Valen\App;

use Exception;
use Dotenv\Dotenv;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Valen\App\Application\Youtube\UseCase\Channel\DeleteChannelUseCase;
use Valen\App\Application\Youtube\UseCase\Channel\AddChannelUseCase;
use Valen\App\Application\Youtube\UseCase\Video\AddVideoUseCase;
use Valen\App\Domain\Youtube\Channel;
use Valen\App\Domain\Youtube\Video;
use Valen\App\Infrastructure\OpenSearch\OpenSearchClient;
use Valen\App\Infrastructure\Youtube\Mapper\ChannelMapper;
use Valen\App\Infrastructure\Youtube\Mapper\VideoMapper;
use Valen\App\Infrastructure\Youtube\Repository\ChannelRepository;
use Valen\App\Infrastructure\Youtube\Repository\VideoRepository;

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

        $videoArray = [
            'videoId' => '123',
            'title' => 'Test',
            'description' => 'Test',
            'publishedAt' => '2020-10-10',
            'viewCount' => 100,
            'likeCount' => 10,
            'dislikeCount' => 1,
            'commentCount' => 1000,
            'channelId' => 'UC-lHJZR3Gqxm24_Vd_AJ5Yw'
        ];

        $videoArray2 = [
            'videoId' => '123',
            'title' => 'Test2',
            'description' => 'Test2',
            'publishedAt' => '2020-10-12',
            'viewCount' => 102,
            'likeCount' => 11,
            'dislikeCount' => 12,
            'commentCount' => 1002,
            'channelId' => 'OT-lHJZR3Gqxm24_Vd_AJ5Yw'
        ];

        $channel = Channel::createFromArray($channelArray);
        $video = Video::createFromArray($videoArray);
        $video2 = Video::createFromArray($videoArray2);

        echo '<pre>';

        try {
            $addChannelUseCase = $this->container->get('addChannelUseCase');
            $addChannelUseCase->execute($channel);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $addVideoUseCase = $this->container->get('addVideoUseCase');
            $addVideoUseCase->execute($video);

            $addVideoUseCase->execute($video2);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $deleteChannelUseCase = $this->container->get('deleteChannelUseCase');
            // $deleteChannelUseCase->execute($channel->getChannelId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }

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

        $container->register('videoMapper', VideoMapper::class);
        $container->register('videoRepository', VideoRepository::class)
            ->addArgument(new Reference('openSearchClient'))
            ->addArgument(new Reference('videoMapper'));

        $container->register('addChannelUseCase', AddChannelUseCase::class)
            ->addArgument(new Reference('channelRepository'));
        $container->register('deleteChannelUseCase', DeleteChannelUseCase::class)
            ->addArgument(new Reference('channelRepository'))
            ->addArgument(new Reference('videoRepository'));

        $container->register('addVideoUseCase', AddVideoUseCase::class)
            ->addArgument(new Reference('channelRepository'))
            ->addArgument(new Reference('videoRepository'));

        $this->container = $container;
    }
}
