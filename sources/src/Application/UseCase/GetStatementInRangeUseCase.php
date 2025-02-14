<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Event\StatementPersistedEvent;
use App\Domain\ValueObject\Account;
use App\Domain\ValueObject\Date;

class GetStatementInRangeUseCase
{
    public function __invoke(GetStatementInRangeUseCaseRequest $request): StatementPersistedEvent
    {
        return new StatementPersistedEvent(
            (new Account($request->account))->getValue(),
            (new Date($request->dateFrom))->getValue(),
            (new Date($request->dateTo))->getValue()
        );
    }
}