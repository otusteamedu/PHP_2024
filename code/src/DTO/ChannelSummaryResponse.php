<?php

namespace SergeyShirykalov\YoutubeChannels\DTO;

readonly class ChannelSummaryResponse
{
    public function __construct(
        private string $channel,
        private int    $sumLikes,
        private int    $sumDislikes,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'sum_likes' => $this->sumLikes,
            'sum_dislikes' => $this->sumDislikes,
        ];
    }

}