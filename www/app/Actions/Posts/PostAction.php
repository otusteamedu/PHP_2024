<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Posts;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PgPdo;
use Hukimato\App\Models\Posts\Post;
use Hukimato\App\Models\Posts\PostMapper;
use Hukimato\App\Models\Users\UserMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\PostParamsHandler;
use Hukimato\App\Views\JsonView;

class PostAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();
        $requestBody = $requestData['body'];

        $userMapper = new UserMapper(PgPdo::getInstance());

        $user = $userMapper->findOne($requestData['username']);


        $postMapper = new PostMapper(PgPdo::getInstance());
        $result = $postMapper->insert($requestData['username'], new Post(
            $requestBody['title'],
            $requestBody['content'],
            $user
        ));

        echo JsonView::render($result);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new PostParamsHandler();
    }
}
