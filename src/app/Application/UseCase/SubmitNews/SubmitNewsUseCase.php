<?php

namespace App\Application\UseCase\SubmitNews;

use App\Application\Gateway\ParserUrl\ParserUrlGatewayInterface;
use App\Application\Gateway\ParserUrl\ParserUrlGatewayRequest;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class SubmitNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface      $factory,
        private readonly NewsRepositoryInterface   $repository,
        private readonly ParserUrlGatewayInterface $parserUrlGateway,
    )
    {
    }

    public function __invoke(SubmitNewsRequest $request): SubmitNewsResponse
    {
        $parserUrlGatewayResponse = $this->parserUrlGateway->getTitle(new ParserUrlGatewayRequest($request->url));

        $news = $this->factory->create($parserUrlGatewayResponse->title, $request->url, now());

        $this->repository->save($news);

        return new SubmitNewsResponse($news->getId());
    }
}
