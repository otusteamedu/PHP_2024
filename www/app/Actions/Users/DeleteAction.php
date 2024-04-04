<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Users;

use Hukimato\App\Models\Events\User;
use Hukimato\App\Views\JsonView;

class DeleteAction
{
    public function run()
    {
        echo JsonView::render(['message' => User::deleteAll()]);
    }
}
