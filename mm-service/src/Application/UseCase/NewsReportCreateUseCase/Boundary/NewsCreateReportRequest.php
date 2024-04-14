<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsReportCreateUseCase\Boundary;

readonly class NewsCreateReportRequest
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        private array $ids,
        private string $format,
        private ?string $template,
    ) {
    }

    /**
     * @return int[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }
}
