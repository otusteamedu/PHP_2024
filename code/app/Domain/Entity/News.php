<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\ExportDate;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class News
{
    /** @var integer|null */
    private ?int $id = null;

    public function __construct(
        private Url $url,
        private Title $title,
        private ExportDate $exportDate,
    ) {
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return ExportDate
     */
    public function getExportDate(): ExportDate
    {
        return $this->exportDate;
    }
}
