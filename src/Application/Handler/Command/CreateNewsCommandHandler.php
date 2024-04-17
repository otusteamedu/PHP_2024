<?php

declare(strict_types=1);

namespace App\Application\Handler\Command;

use App\Application\DocumentParser\DocumentParserInterface;
use App\Application\DocumentParser\Request\DocumentParserRequest;
use App\Application\Handler\Response\CreateNewsResponse;
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
    public function __invoke(CreateNewsCommand $command): CreateNewsResponse
    {
        $docParserResponse = $this->documentParser->parse(new DocumentParserRequest($command->getUrl()));

        $news = new News(
            new Url($command->getUrl()),
            new Title($docParserResponse->title)
        );

        $this->newsRepository->save($news);

        return new CreateNewsResponse($news->getId());
    }
}
