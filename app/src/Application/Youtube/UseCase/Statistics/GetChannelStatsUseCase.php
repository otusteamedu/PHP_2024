<?php

namespace Valen\App\Application\Youtube\UseCase\Statistics;

use Valen\App\Domain\Youtube\Channel;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;
use Valen\App\Domain\Youtube\VideoRepositoryInterface;

class GetChannelStatsUseCase
{
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly VideoRepositoryInterface $videoRepository
    ) {
    }

    public function execute(string $channelId): array
    {
        // Проверяем существование канала
        $channel = $this->channelRepository->findById($channelId);

        if (!$channel instanceof Channel) {
            throw new \InvalidArgumentException("Канал с ID {$channelId} не найден");
        }

        // Получаем все видео канала
        $videos = $this->videoRepository->findByChannelId($channelId);

        // Суммируем лайки и дизлайки
        $totalLikes = 0;
        $totalDislikes = 0;

        foreach ($videos as $video) {
            $totalLikes += $video->getLikeCount();
            $totalDislikes += $video->getDislikeCount();
        }

        // Создаем DTO с результатом
        $stats = new ChannelStatsDTO($totalLikes, $totalDislikes);

        return $stats->toArray();
    }
}
