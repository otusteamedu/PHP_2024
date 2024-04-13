<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Users;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PgPdo;
use Hukimato\App\Models\Users\User;
use Hukimato\App\Models\Users\UserMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\PostParamsHandler;
use Hukimato\App\Views\JsonView;

class PutAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();
        $requestBody = $requestData['body'];

        $userMapper = new UserMapper(PgPdo::getInstance());
        $user = $userMapper->findOne($requestData['username']);

        $result = $userMapper->update($requestData['username'], new User(
            $requestBody['username'] ?? $user->username,
            $requestBody['email'] ?? $user->email,
        ));

        echo JsonView::render(['message' => $result]);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new PostParamsHandler();
    }
}
