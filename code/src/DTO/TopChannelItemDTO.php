<?php

namespace SergeyShirykalov\YoutubeChannels\DTO;

readonly class TopChannelItemDTO
{
    public function __construct(
        private string $channel,
        private float  $ratio,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'ratio' => $this->ratio,
        ];
    }

}