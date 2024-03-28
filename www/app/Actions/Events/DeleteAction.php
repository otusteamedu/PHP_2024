<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Actions\Events;

use Hukimato\RedisApp\Models\Events\Event;
use Hukimato\RedisApp\Views\JsonView;

class DeleteAction
{
    public function run()
    {
        echo JsonView::render(['message' => Event::deleteAll()]);
    }
}
