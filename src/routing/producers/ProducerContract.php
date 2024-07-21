<?php

declare(strict_types=1);

namespace app\routing\producers;

use app\routing\entity\PriorityRange;

interface ProducerContract
{
    public function publish(array $msg, string $queuesName, array $headers = [], PriorityRange $priority = PriorityRange::MIN): bool;
}
