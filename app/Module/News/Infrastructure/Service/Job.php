<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Service;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Module\News\Application\Service\Dto\Consumer;
use Module\News\Application\Service\Dto\Message;

final class Job implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Consumer $consumer,
        private readonly Message $message,
    ) {
    }

    public function handle(): void
    {
        $this->consumer->handle($this->message);
    }
}
