<?php

declare(strict_types=1);

namespace App\Infrastructure\Exporter;

use App\Domain\News\News;

class HTMLExporter extends BaseExporter
{
    public function exportNews(News $news): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{$news->getTitle()}</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <p>{$news->getBody()}</p>
  <p>Author: {$news->getAuthor()->getUsername()}</p>
</body>

</html>
HTML;
    }
}
