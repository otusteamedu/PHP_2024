<?php

namespace SergeyShirykalov\YoutubeChannels\DTO;

class VideoAddResponse
{
    public function __construct(
        private string $id,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): VideoAddResponse
    {
        $this->id = $id;
        return $this;
    }

}