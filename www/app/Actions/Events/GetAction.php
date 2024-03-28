<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Actions\Events;

use Hukimato\RedisApp\Actions\ActionInterface;
use Hukimato\RedisApp\Models\Events\Event;
use Hukimato\RedisApp\ParamsHandlers\Events\GetParamsHandler;
use Hukimato\RedisApp\ParamsHandlers\ParamsHandlerInterface;
use Hukimato\RedisApp\Views\JsonView;

class GetAction extends ActionInterface
{

    public function run()
    {
        $event = Event::find(static::getParamsHandler()->getParams());
        echo JsonView::render($event);
    }

    protected function getParamsHandler(): ParamsHandlerInterface
    {
        return new GetParamsHandler();
    }
}
