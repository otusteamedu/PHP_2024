<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Mapper;

use Alogachev\Homework\Application\UseCase\Request\GetBankStatementRequest;
use Symfony\Component\HttpFoundation\Request;

class GetBankStatementMapper
{
    public function map(Request $request): GetBankStatementRequest
    {
        $id = $request->query->get('statementId');

        return new GetBankStatementRequest(
            (int)$id,
        );
    }
}
