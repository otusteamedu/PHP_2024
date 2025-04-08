<?php

namespace Valen\App\Application\Youtube\UseCase\Statistics;

class ChannelStatsDTO
{
    /**
     * @param int $likes Общее количество лайков
     * @param int $dislikes Общее количество дизлайков
     */
    public function __construct(
        private readonly int $likes = 0,
        private readonly int $dislikes = 0
    ) {
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * Представление в виде массива
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'likes' => $this->likes,
            'dislikes' => $this->dislikes
        ];
    }
}
