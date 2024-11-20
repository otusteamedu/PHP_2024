<?php

declare(strict_types=1);

namespace App\Infrastructure\Loader;

use App\Application\Loader\ContentLoaderInterface;
use App\Application\Loader\ContentLoadResult;
use Exception;

class ContentLoader implements ContentLoaderInterface
{

    /**
     * @param string $url
     * @return ContentLoadResult
     * @throws Exception
     */
    public function load(string $url): ContentLoadResult
    {
        $html = file_get_contents($url);

        if ($html === false) {
            throw new Exception("Can't load html");
        }

        return new ContentLoadResult($html);
    }
}
