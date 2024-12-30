<?php

namespace App\Domain;

use SplFileInfo;

interface HandlerInterface
{
    public function setNext(HandlerInterface $handler): void;
    public function handle(SplFileInfo $fileinfo): bool;
}
