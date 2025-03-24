<?php

namespace App\Infrastructure\ChainOfResponsibility;

use App\Application\ChainOfResponsibility\CookingProcessHandler;
use App\Application\ChainOfResponsibility\CookingProcessRequest;
use App\Domain\Entity\Burger;
use App\Domain\Entity\Salad;
use App\Domain\Enum\Status;

class CookingStandardHandler extends CookingProcessHandler
{
    public function handle(CookingProcessRequest $request): void
    {
        if ($request->foodComposite instanceof Burger && $request->foodComposite->contains(Salad::class)) {
            $request->setStatus(Status::FAILED);
            throw new \Exception('Бургер не может содержать салат - что за ботва!');
        }

        $request->setStatus(Status::COOKING);

        parent::handle($request);
    }
}