<?php

declare(strict_types=1);

namespace Valen\App\Application\Youtube\UseCase\Statistics;

use DomainException;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;
use Valen\App\Domain\Youtube\VideoRepositoryInterface;

final readonly class GetChannelEngagementStatsUseCase
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private VideoRepositoryInterface $videoRepository,
    ) {
    }

    /**
     * Получение суммарных показателей лайков и дизлайков для канала
     *
     * @return array{
     *     channel: string,
     *     channelId: string,
     *     totalLikes: int,
     *     totalDislikes: int,
     *     likeToDislikeRatio: float
     * }
     * @throws DomainException Если канал не найден
     */
    public function execute(string $channelId): array
    {
        $channel = $this->channelRepository->findById($channelId);
        if ($channel === null) {
            throw new DomainException("Канал с ID {$channelId} не найден");
        }

        $videos = $this->videoRepository->findByChannelId($channelId);

        $totalLikes = 0;
        $totalDislikes = 0;

        foreach ($videos as $video) {
            $totalLikes += $video->likeCount;
            $totalDislikes += $video->dislikeCount;
        }

        $likeToDislikeRatio = $totalDislikes > 0
            ? $totalLikes / $totalDislikes
            : ($totalLikes > 0 ? PHP_FLOAT_MAX : 0);

        return [
            'channel' => $channel->title,
            'channelId' => $channel->channelId,
            'totalLikes' => $totalLikes,
            'totalDislikes' => $totalDislikes,
            'likeToDislikeRatio' => $likeToDislikeRatio
        ];
    }
}
