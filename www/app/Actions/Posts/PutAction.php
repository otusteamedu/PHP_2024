<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Posts;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PgPdo;
use Hukimato\App\Models\Posts\Post;
use Hukimato\App\Models\Posts\PostMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\PostParamsHandler;
use Hukimato\App\Views\JsonView;

class PutAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();
        $requestBody = $requestData['body'];

        $postMapper = new PostMapper(PgPdo::getInstance());
        $post = $postMapper->findOne((int)$requestData['post_id']);

        $result = $postMapper->update(new Post(
            $requestBody['title'],
            $requestBody['content'] ?? $post->content,
            id: $post->id,
        ));

        echo JsonView::render(['message' => $result]);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new PostParamsHandler();
    }
}
