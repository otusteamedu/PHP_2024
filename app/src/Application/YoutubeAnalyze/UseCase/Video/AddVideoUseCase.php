<?php

declare(strict_types=1);

namespace Valen\App\Application\UseCase\Video;

use DomainException;
use Valen\App\Domain\YoutubeAnalyze\ChannelRepositoryInterface;
use Valen\App\Domain\YoutubeAnalyze\Video;
use Valen\App\Domain\YoutubeAnalyze\VideoRepositoryInterface;

final readonly class AddVideoUseCase
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private VideoRepositoryInterface $videoRepository,
    ) {
    }

    /**
     * Добавление нового видео
     *
     * @throws DomainException Если канал не найден
     */
    public function execute(Video $video): void
    {
        // Проверяем, что канал существует перед добавлением видео
        $channel = $this->channelRepository->findById($video->channelId);

        if ($channel === null) {
            throw new DomainException("Канал с ID {$video->channelId} не найден");
        }

        $this->videoRepository->save($video);
    }
}
