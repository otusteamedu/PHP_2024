<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Interface;

use Module\News\Domain\Entity\NewsCollection;
use Module\News\Domain\ValueObject\Url;

interface ReportGeneratorServiceInterface
{
    public function generate(NewsCollection $newsCollection): Url;
}
