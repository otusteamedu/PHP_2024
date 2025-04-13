<?php

declare(strict_types=1);

namespace Valen\App;

use Exception;
use Dotenv\Dotenv;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Valen\App\Application\Youtube\UseCase\Channel\DeleteChannelUseCase;
use Valen\App\Application\Youtube\UseCase\Channel\AddChannelUseCase;
use Valen\App\Application\Youtube\UseCase\Statistics\GetChannelStatsUseCase;
use Valen\App\Application\Youtube\UseCase\Statistics\GetTopChannelsByLikesRatioUseCase;
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

        $channelArray2 = [
            'channelId' => 'UF-lHJZR3Gqxm24_Vd_AJ5Yw',
            'title' => 'Test2',
            'description' => 'Test2',
            'subscriberCount' => 100002,
            'videoCount' => 200,
            'publishedAt' => '2020-10-10'
        ];

        $videoArray = [
            'videoId' => '123',
            'title' => 'Test',
            'description' => 'Test',
            'publishedAt' => '2020-10-10',
            'viewCount' => 100,
            'likeCount' => 1000,
            'dislikeCount' => 100,
            'commentCount' => 1000,
            'channelId' => 'UC-lHJZR3Gqxm24_Vd_AJ5Yw'
        ];

        $videoArray2 = [
            'videoId' => '12345',
            'title' => 'Test2',
            'description' => 'Test2',
            'publishedAt' => '2020-10-12',
            'viewCount' => 102,
            'likeCount' => 1100,
            'dislikeCount' => 120,
            'commentCount' => 1002,
            'channelId' => 'UF-lHJZR3Gqxm24_Vd_AJ5Yw'
        ];

        $videoArray3 = [
            'videoId' => '1234',
            'title' => 'Test2',
            'description' => 'Test2',
            'publishedAt' => '2020-10-12',
            'viewCount' => 102,
            'likeCount' => 1100,
            'dislikeCount' => 120,
            'commentCount' => 1002,
            'channelId' => 'UC-lHJZR3Gqxm24_Vd_AJ5Yw'
        ];

        $channel = Channel::createFromArray($channelArray);
        $channel2 = Channel::createFromArray($channelArray2);
        $video = Video::createFromArray($videoArray);
        $video2 = Video::createFromArray($videoArray2);
        $video3 = Video::createFromArray($videoArray3);

        echo '<pre>';

        try {
            $addChannelUseCase = $this->container->get('addChannelUseCase');
            $addChannelUseCase->execute($channel);
            $addChannelUseCase->execute($channel2);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        try {
            $addVideoUseCase = $this->container->get('addVideoUseCase');
            $addVideoUseCase->execute($video);
            $addVideoUseCase->execute($video2);
            $addVideoUseCase->execute($video3);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $videos = $channel->getVideos();
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        try {
            $channel->setVideoRepository($this->container->get('videoRepository'));
            $lazyLoadVideos = $channel->getVideos();
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        print_r($lazyLoadVideos);

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

        $container->register('getChannelStatsUseCase', GetChannelStatsUseCase::class)
            ->addArgument(new Reference('channelRepository'))
            ->addArgument(new Reference('videoRepository'));

        $container->register('getTopChannelsByLikesRatioUseCase', GetTopChannelsByLikesRatioUseCase::class)
            ->addArgument(new Reference('channelRepository'))
            ->addArgument(new Reference('videoRepository'));

        $this->container = $container;
    }
}
