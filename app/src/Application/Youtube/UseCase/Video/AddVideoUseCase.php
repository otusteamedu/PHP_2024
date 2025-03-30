<?php

declare(strict_types=1);

namespace Valen\App\Application\Youtube\UseCase\Video;

use DomainException;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;
use Valen\App\Domain\Youtube\Video;
use Valen\App\Domain\Youtube\VideoRepositoryInterface;

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
