<?php

namespace SergeyShirykalov\YoutubeChannels;

class ElasticMappings
{
    public static function getMappings()
    {
        return json_decode(file_get_contents(__DIR__ . "/mappings.json"), true);
    }
}