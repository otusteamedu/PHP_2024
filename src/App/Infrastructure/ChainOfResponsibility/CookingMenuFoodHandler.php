<?php

namespace App\Infrastructure\ChainOfResponsibility;

use App\Application\ChainOfResponsibility\CookingProcessHandler;
use App\Application\ChainOfResponsibility\CookingProcessRequest;
use App\Domain\Entity\Hotdog;
use App\Domain\Enum\Status;

class CookingMenuFoodHandler extends CookingProcessHandler
{
    public function handle(CookingProcessRequest $request): void
    {
        if ($request->foodComposite instanceof Hotdog) {
            $request->setStatus(Status::FAILED);
            throw new \Exception('Хотдог временно не готовим!');
        }

        parent::handle($request);
    }
}