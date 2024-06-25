<?php

declare(strict_types=1);

namespace Viking311\Chat\Command;

interface CommandInterface
{

    public function execute(): void;
}
