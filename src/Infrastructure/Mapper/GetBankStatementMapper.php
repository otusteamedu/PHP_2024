<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Mapper;

use Alogachev\Homework\Application\UseCase\Request\GetBankStatementRequest;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class GetBankStatementMapper
{
    public function map(Request $request, array $urlParams = []): GetBankStatementRequest
    {
        $statementId = $urlParams[1] ?? null;

        if (is_null($statementId)) {
            throw new InvalidArgumentException('Не передан идентификатор запроса на банковскую выгрузку');
        }

        return new GetBankStatementRequest(
            (int)$statementId,
        );
    }
}
