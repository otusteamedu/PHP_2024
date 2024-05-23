<?php

declare(strict_types=1);

namespace Module\News\Domain\Factory;

use Core\Domain\Factory\UuidFactoryInterface;
use Module\News\Domain\Entity\News;
use Module\News\Domain\ValueObject\Title;
use Module\News\Domain\ValueObject\Url;

final readonly class NewsFactory
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory
    ) {
    }

    public function create(string $url, string $title): News
    {
        return new News($this->uuidFactory->next(), new Url($url), new Title($title));
    }
}
