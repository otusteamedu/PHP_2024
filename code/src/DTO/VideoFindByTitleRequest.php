<?php

namespace SergeyShirykalov\YoutubeChannels\DTO;

class VideoFindByTitleRequest
{
    public function __construct(
        private string $channel,
        private string $title,
    )
    {
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): VideoFindByTitleRequest
    {
        $this->channel = $channel;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): VideoFindByTitleRequest
    {
        $this->title = $title;
        return $this;
    }

}