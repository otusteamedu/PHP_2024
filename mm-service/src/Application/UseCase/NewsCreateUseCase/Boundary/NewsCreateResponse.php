<?php
declare(strict_types=1);

namespace App\Application\UseCase\NewsCreateUseCase\Boundary;

use App\Domain\Entity\News;

class NewsCreateResponse
{
    private int $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param News $news
     * @return self
     */
    public static function fromBoundary(News $news): self
    {
        return new self(
            $news->getId()
        );
    }
}
