<?php

declare(strict_types=1);

namespace App\Application\ReportGenerator;

use App\Application\ReportGenerator\Request\ReportGeneratorRequest;
use App\Application\ReportGenerator\Response\ReportGeneratorResponse;

// Лучше убрать в отдельный подкаталог ReportGenerator и на уровне Infrastructure тоже, чтобы было легче искать
interface ReportGeneratorInterface
{
    public function generate(ReportGeneratorRequest $dto): ReportGeneratorResponse;
}
