<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase;

use Alogachev\Homework\Application\Render\RenderInterface;

class GetBankStatementUseCase
{
    public function __construct(
        private readonly RenderInterface $render,
    ) {
    }

    /**
     * ToDo: Добавить дто ответа.
     */
    public function __invoke(): void
    {
        $this->render->render('index.php');
    }
}
