<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Factory;

use Module\News\Domain\Entity\News;
use Module\News\Infrastructure\Model\NewsModel;

final class NewsModelMapper
{
    public function fromEntity(News $news, ?NewsModel $model = null): NewsModel
    {
        $model = $model ?? new NewsModel();
        $model->id = $news->getId();
        $model->url = $news->getUrl()->getValue();
        $model->title = $news->getTitle()->getValue();
        $model->date = $news->getDate()->format('Y-m-d H:i:s');
        $model->status = $news->getStatus()->value;

        return $model;
    }
}
