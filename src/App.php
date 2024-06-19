<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Application\UseCase\BankStatementFormUseCase;
use Alogachev\Homework\Application\UseCase\GenerateBankStatementUseCase;
use Alogachev\Homework\Infrastructure\Render\HtmlRenderManager;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

use function DI\create;
use function DI\get;

final class App
{
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $request = $this->resolveRequest();
        $useCase = $this->resolveUseCase($request);

        $useCase();
    }

    private function resolveDI(): ContainerInterface
    {
        return new Container([
            BankStatementFormUseCase::class => create()->constructor(get(HtmlRenderManager::class)),
            GenerateBankStatementUseCase::class => create()->constructor(get(HtmlRenderManager::class)),
        ]);
    }

    public function resolveRequest(): Request
    {
        return Request::createFromGlobals();
    }

    public function resolveUseCase(Request $request): object
    {
        $container = $this->resolveDI();

        $useCases = [
            [
                'GET',
                '/bank/statement',
                $container->get(BankStatementFormUseCase::class),
            ],
            [
                'POST',
                '/bank/statement/generate',
                $container->get(GenerateBankStatementUseCase::class),
            ],
        ];

        $useCase = null;

        foreach ($useCases as $case) {
            if ($case[0] === $request->getPathInfo()) {
                $useCase = $case[2];
                break;
            }
        }

        return $useCase;
    }
}
