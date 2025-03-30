<?php

declare(strict_types=1);

namespace Valen\App\Application\UseCase\Channel;

use DomainException;
use Valen\App\Domain\YoutubeAnalyze\ChannelRepositoryInterface;
use Valen\App\Domain\YoutubeAnalyze\VideoRepositoryInterface;

final readonly class DeleteChannelUseCase
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private VideoRepositoryInterface $videoRepository,
    ) {
    }

    public function execute(string $channelId): void
    {
        // Проверка существования канала
        $channel = $this->channelRepository->findById($channelId);
        if ($channel === null) {
            throw new DomainException("Канал с ID {$channelId} не найден");
        }

        // Получаем все видео канала для удаления
        $videos = $this->videoRepository->findByChannelId($channelId);

        // Удаляем каждое видео
        foreach ($videos as $video) {
            $this->videoRepository->delete($video->videoId);
        }

        // Удаляем канал
        $this->channelRepository->delete($channelId);
    }
}
