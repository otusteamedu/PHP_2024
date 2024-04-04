<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Users;

use Hukimato\App\Actions\ActionInterface;
use Hukimato\App\Models\Events\User;
use Hukimato\App\ParamsHandlers\Events\PostParamsHandler;
use Hukimato\App\ParamsHandlers\ParamsHandlerInterface;
use Hukimato\App\Views\JsonView;

class PostAction extends ActionInterface
{

    public function run()
    {
        $event = new User(static::getParamsHandler()->getParams());
        echo JsonView::render(['message' => $event->save()]);
    }

    protected function getParamsHandler(): ParamsHandlerInterface
    {
        return new PostParamsHandler();
    }
}
