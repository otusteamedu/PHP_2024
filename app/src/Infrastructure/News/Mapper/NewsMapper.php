<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\News\Mapper;

use Valen\App\Domain\News\Entity\News;

final class NewsMapper
{
    public function toStorage(News $news): array
    {
        return [
            'id' => $news->getId(),
            'url' => $news->getUrl()->url,
            'title' => $news->getTitle()->title
        ];
    }

    public function toDomain(array $channel): News
    {
        return News::createFromArray($channel);
    }
}
