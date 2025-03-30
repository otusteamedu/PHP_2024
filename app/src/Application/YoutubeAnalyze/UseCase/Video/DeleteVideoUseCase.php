<?php

declare(strict_types=1);

namespace Valen\App\Application\UseCase\Video;

use Valen\App\Domain\YoutubeAnalyze\VideoRepositoryInterface;

final readonly class DeleteVideoUseCase
{
    public function __construct(
        private VideoRepositoryInterface $videoRepository,
    ) {
    }

    /**
     * Удаление отдельного видео
     *
     * @throws \DomainException Если видео не найдено
     */
    public function execute(string $videoId): void
    {
        $video = $this->videoRepository->findById($videoId);
        if ($video === null) {
            throw new \DomainException("Видео с ID {$videoId} не найдено");
        }

        $this->videoRepository->delete($videoId);
    }
}
