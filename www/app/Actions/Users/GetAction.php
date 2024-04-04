<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Users;

use Hukimato\App\Actions\ActionInterface;
use Hukimato\App\Models\Events\User;
use Hukimato\App\ParamsHandlers\Events\GetParamsHandler;
use Hukimato\App\ParamsHandlers\ParamsHandlerInterface;
use Hukimato\App\Views\JsonView;

class GetAction extends ActionInterface
{

    public function run()
    {
        $event = User::find(static::getParamsHandler()->getParams());
        echo JsonView::render($event);
    }

    protected function getParamsHandler(): ParamsHandlerInterface
    {
        return new GetParamsHandler();
    }
}
