<?php
declare(strict_types=1);

namespace App\Application\UseCase\NewsReportCreateUseCase\Boundary;

readonly class NewsCreateReportRequest
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        private array  $ids
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
}
