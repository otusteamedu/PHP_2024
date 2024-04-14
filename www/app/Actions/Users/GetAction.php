<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Users;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PdoFactory;
use Hukimato\App\Models\Users\UserMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\GetParamsHandler;
use Hukimato\App\Views\JsonView;

class GetAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();

        $userMapper = new UserMapper(PdoFactory::createPgPDO());
        $user = $userMapper->findOne($requestData['username']);

        echo JsonView::render($user);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new GetParamsHandler();
    }
}
