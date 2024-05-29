<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use Rmulyukov\Hw\Application\UseCase\Publish\PublishRequest;
use Rmulyukov\Hw\Application\UseCase\Publish\PublishUseCase;

readonly final class App
{
    public function __construct(
        private PublishUseCase $useCase,
    ) {
    }

    public function run(Request $request): void
    {
        $publishRequest = new PublishRequest(
            $request->getParam('message'),
            $request->getParam('email')
        );
        ($this->useCase)($publishRequest);
    }
}
