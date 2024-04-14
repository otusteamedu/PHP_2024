<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Posts;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PdoFactory;
use Hukimato\App\Models\Posts\PostMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\GetParamsHandler;
use Hukimato\App\Views\JsonView;

class ListAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();

        $postMapper = new PostMapper(PdoFactory::createPgPDO());
        $posts = $postMapper->findAllByUser($requestData['username']);

        echo JsonView::render($posts);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new GetParamsHandler();
    }
}
