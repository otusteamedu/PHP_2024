<?php

declare(strict_types=1);

namespace Valen\App\Application\UseCase\Channel;

use Valen\App\Domain\YoutubeAnalyze\Channel;
use Valen\App\Domain\YoutubeAnalyze\ChannelRepositoryInterface;

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
