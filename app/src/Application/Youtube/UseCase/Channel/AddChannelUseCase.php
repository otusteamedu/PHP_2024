<?php

declare(strict_types=1);

namespace Valen\App\Application\Youtube\UseCase\Channel;

use Valen\App\Domain\Youtube\Channel;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;

final readonly class AddChannelUseCase
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
    ) {
    }

    public function execute(Channel $channel): void
    {
        $this->channelRepository->save($channel);
    }
}
