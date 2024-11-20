<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use App\Application\Loader\ContentLoaderInterface;
use App\Application\Parser\ParserInterface;
use App\Application\Validator\Url;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;

readonly class AddNewsUseCase
{
    public function __construct(
        private NewsFactoryInterface $newsFactory,
        private NewsRepositoryInterface $newsRepository,
        private ParserInterface $parser,
        private Url $urlValidator,
        private ContentLoaderInterface $contentLoader
    ) {
    }

    /**
     * @param AddNewsRequest $request
     * @return AddNewsResponse
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        if (!$this->urlValidator->isValid($request->url)) {
            throw new InvalidArgumentException('Invalid URL');
        }

        $content = $this->contentLoader->load($request->url);

        $parserResult = $this->parser->parse($content->content);

        $news  = $this->newsFactory->create(
            $request->url,
            $parserResult->title,
            new DateTimeImmutable()
        );

        $this->newsRepository->save($news);

        return new AddNewsResponse(
            $news->getId()
        );
    }
}
