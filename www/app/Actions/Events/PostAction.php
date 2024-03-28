<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Actions\Events;

use Hukimato\RedisApp\Actions\ActionInterface;
use Hukimato\RedisApp\Models\Events\Event;
use Hukimato\RedisApp\ParamsHandlers\Events\PostParamsHandler;
use Hukimato\RedisApp\ParamsHandlers\ParamsHandlerInterface;
use Hukimato\RedisApp\Views\JsonView;

class PostAction extends ActionInterface
{

    public function run()
    {
        $event = new Event(static::getParamsHandler()->getParams());
        echo JsonView::render(['message' => $event->save()]);
    }

    protected function getParamsHandler(): ParamsHandlerInterface
    {
        return new PostParamsHandler();
    }
}
