<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use App\Application\Parser\ParserInterface;
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
        private ParserInterface $parser
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
        if (filter_var($request->url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid URL');
        }

        $html = file_get_contents($request->url);

        if ($html === false) {
            throw new Exception("Can't load html");
        }

        $parserResult = $this->parser->parse($html);

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
