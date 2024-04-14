<?php
declare(strict_types=1);

namespace App\Application\UseCase\NewsReportCreateUseCase\Boundary;

readonly class NewsCreateReportRequest
{
    /**
     * @param int[] $ids
     * @param string $format
     * @param string|null $template
     */
    public function __construct(
        private array $ids,
        private string $format,
        private ?string $template,
    )
    {
    }

    /**
     * @return int[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }
}
