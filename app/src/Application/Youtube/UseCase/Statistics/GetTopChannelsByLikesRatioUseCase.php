<?php

namespace Valen\App\Application\Youtube\UseCase\Statistics;

use Valen\App\Domain\Youtube\ChannelRepositoryInterface;
use Valen\App\Domain\Youtube\VideoRepositoryInterface;

class GetTopChannelsByLikesRatioUseCase
{
    private const int MIN_DISLIKES_THRESHOLD = 10;

    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly VideoRepositoryInterface $videoRepository
    ) {
    }

    public function execute(int $limit = 10): array
    {
        // Получаем все каналы
        $channels = $this->channelRepository->findAll();

        $channelStats = [];

        // Для каждого канала вычисляем статистику
        foreach ($channels as $channel) {
            $channelId = $channel->getChannelId();

            // Получаем все видео канала
            $videos = $this->videoRepository->findByChannelId($channelId);

            // Суммируем лайки и дизлайки
            $totalLikes = 0;
            $totalDislikes = 0;

            foreach ($videos as $video) {
                $totalLikes += $video->getLikeCount();
                $totalDislikes += $video->getDislikeCount();
            }

            // Пропускаем каналы, у которых мало дизлайков (чтобы избежать искажения статистики)
            // и каналы без видео или без лайков
            if ($totalDislikes < self::MIN_DISLIKES_THRESHOLD || $totalLikes === 0) {
                continue;
            }

            // Вычисляем соотношение лайков к дизлайкам
            $ratio = $totalLikes / $totalDislikes;

            $channelStats[] = new ChannelRatingDTO(
                $channelId,
                $channel->getTitle(),
                $totalLikes,
                $totalDislikes,
                $ratio
            );
        }

        // Сортируем каналы по соотношению (в порядке убывания)
        usort($channelStats, function (ChannelRatingDTO $a, ChannelRatingDTO $b) {
            return $b->getRatio() <=> $a->getRatio();
        });

        // Ограничиваем результат до запрошенного количества
        $channelStats = array_slice($channelStats, 0, $limit);

        // Преобразуем результат в массив
        $result = [];
        foreach ($channelStats as $stat) {
            $result[] = $stat->toArray();
        }

        return $result;
    }
}
