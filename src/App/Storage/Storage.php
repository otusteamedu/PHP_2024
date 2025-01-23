<?php

namespace App\Storage;

interface Storage
{
    public function migrate(): void;

    public function addChannel(array $data): void;

    public function addVideo(array $data): void;
}