<?php

declare(strict_types=1);

namespace App\Application\Handler\Command;

use App\Application\Command\GenerateReportCommand;
use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Application\ReportGenerator\Request\ReportGeneratorRequest;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;
use Ecotone\Modelling\Attribute\CommandHandler;

readonly class GenerateReportCommandHandler
{
    public function __construct(
        private NewsInterface $newsRepository,
        private ReportGeneratorInterface $reportGenerator
    ) {}

    #[CommandHandler]
    public function __invoke(GenerateReportCommand $command): void
    {
        $news = $this->newsRepository->getById([
            'id' => $command->getIds()
        ]);
        $titles = array_map(fn(News $item) => $item->getTitle(), $news);
        $this->reportGenerator->generate(new ReportGeneratorRequest($titles));
    }
}
