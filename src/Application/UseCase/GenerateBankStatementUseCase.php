<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase;

use Alogachev\Homework\Application\Render\RenderInterface;

class GenerateBankStatementUseCase
{
    public function __construct(
        private readonly RenderInterface $render,
    ) {
    }

    public function __invoke(): void
    {
        $this->render->render('templates/success-generated.html');
    }
}
