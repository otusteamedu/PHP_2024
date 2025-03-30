<?php

declare(strict_types=1);

namespace Valen\App\Application\Youtube\UseCase\Statistics;

use DomainException;
use InvalidArgumentException;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;

final readonly class GetTopChannelsByLikeRatioUseCase
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private GetChannelEngagementStatsUseCase $statsUseCase,
    ) {
    }

    /**
     * Получение топ-N каналов с лучшим соотношением лайков и дизлайков
     *
     * @return array<int, array{
     *     channel: string,
     *     channelId: string,
     *     totalLikes: int,
     *     totalDislikes: int,
     *     likeToDislikeRatio: float
     * }>
     * @throws InvalidArgumentException Если limit меньше 1
     */
    public function execute(int $limit = 10): array
    {
        if ($limit < 1) {
            throw new InvalidArgumentException('Limit должен быть положительным числом');
        }

        // Получаем все каналы
        $channels = $this->channelRepository->findAll();

        $result = [];
        foreach ($channels as $channel) {
            try {
                $stats = $this->statsUseCase->execute($channel->channelId);
                $result[] = $stats;
            } catch (DomainException $e) {
                // Пропускаем каналы с ошибками
                continue;
            }
        }

        // Сортируем по соотношению лайков/дизлайков в порядке убывания
        usort($result, fn ($a, $b) => $b['likeToDislikeRatio'] <=> $a['likeToDislikeRatio']);

        // Ограничиваем результат запрошенным количеством
        return array_slice($result, 0, $limit);
    }
}
