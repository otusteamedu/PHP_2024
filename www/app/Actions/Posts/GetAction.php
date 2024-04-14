<?php

declare(strict_types=1);

namespace Hukimato\App\Actions\Posts;

use Hukimato\App\Actions\BaseAction;
use Hukimato\App\Components\PdoFactory;
use Hukimato\App\Models\Posts\PostMapper;
use Hukimato\App\ParamsHandlers\BaseParamsHandler;
use Hukimato\App\ParamsHandlers\Events\GetParamsHandler;
use Hukimato\App\Views\JsonView;

class GetAction extends BaseAction
{
    public function run()
    {
        $requestData = $this->getParams();

        $postMapper = new PostMapper(PdoFactory::createPgPDO());
        $post = $postMapper->findOne((int)$requestData['post_id']);

        echo JsonView::render($post);
    }

    protected function getParamsHandler(): BaseParamsHandler
    {
        return new GetParamsHandler();
    }
}
