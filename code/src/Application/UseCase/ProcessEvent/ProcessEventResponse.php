<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\UseCase\ProcessEvent;

class ProcessEventResponse
{
    public function __construct(
        public readonly string $message
    ){
    }

}
