<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Mapper;

use Alogachev\Homework\Application\UseCase\Request\GenerateBankStatementRequest;
use Symfony\Component\HttpFoundation\Request;

class GenerateBankStatementMapper
{
    public function map(Request $request): GenerateBankStatementRequest
    {
        return new GenerateBankStatementRequest(
            $request->request->get('clientName'),
            $request->request->get('accountNumber'),
            $request->request->get('startDate'),
            $request->request->get('endDate'),
        );
    }
}
