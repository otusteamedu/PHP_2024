<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\SaveFile;

interface SaveFileInterface
{
    public function execute(iterable $data): string;
}
