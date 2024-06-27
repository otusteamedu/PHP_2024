<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Response;

interface JsonResponseInterface
{
    public function toArray(): array;
}
