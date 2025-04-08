<?php

declare(strict_types=1);

namespace Valen\App\Application\Youtube\UseCase\Statistics;

class ChannelRatingDTO
{
    /**
     * @param string $channelId ID канала
     * @param string $channelName Название канала
     * @param int $totalLikes Общее количество лайков
     * @param int $totalDislikes Общее количество дизлайков
     * @param float $ratio Соотношение лайков к дизлайкам
     */
    public function __construct(
        private readonly string $channelId,
        private readonly string $channelName,
        private readonly int $totalLikes,
        private readonly int $totalDislikes,
        private readonly float $ratio
    ) {
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return $this->channelName;
    }

    /**
     * @return int
     */
    public function getTotalLikes(): int
    {
        return $this->totalLikes;
    }

    /**
     * @return int
     */
    public function getTotalDislikes(): int
    {
        return $this->totalDislikes;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * Представление в виде массива
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'channel_id' => $this->channelId,
            'channel_name' => $this->channelName,
            'total_likes' => $this->totalLikes,
            'total_dislikes' => $this->totalDislikes,
            'ratio' => $this->ratio
        ];
    }
}
