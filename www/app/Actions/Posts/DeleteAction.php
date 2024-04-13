<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Posts;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PgPdo;
use Hukimato\App\Models\Posts\PostMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\GetParamsHandler;
use Hukimato\App\Views\JsonView;

class DeleteAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();

        $postMapper = new PostMapper(PgPdo::getInstance());
        $res = $postMapper->delete((int)$requestData['post_id']);

        echo JsonView::render(['message' => $res]);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new GetParamsHandler();
    }
}
