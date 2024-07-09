<?php

declare(strict_types=1);

namespace App\Application\Handler\Command;

use App\Application\DocumentParser\DocumentParserInterface;
use App\Application\DocumentParser\Request\DocumentParserRequest;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use App\Application\Command\CreateNewsCommand;
use Ecotone\Modelling\Attribute\CommandHandler;

class CreateNewsCommandHandler
{
    public function __construct(
        private NewsInterface $newsRepository,
        private DocumentParserInterface $documentParser
    ) {}

    #[CommandHandler]
    public function __invoke(CreateNewsCommand $command): void
    {
        $docParserResponse = $this->documentParser->parse(new DocumentParserRequest($command->getUrl()));

        $news = new News(
            new Url($command->getUrl()),
            new Title($docParserResponse->title),
            $command->getUuid()
        );

        $this->newsRepository->save($news);
    }
}
