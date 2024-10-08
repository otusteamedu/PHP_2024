<?php

namespace Naimushina\ChannelManager;

class Channel
{
    public function __construct( private int $id,
                                 private string $name,
                                 private string $description)
    {
    }



}