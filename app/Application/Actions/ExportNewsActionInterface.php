<?php

namespace App\Application\Actions;

use App\Application\Requests\CreateNewsRequest;
use App\Application\Responses\CreateNewsResponse;
use App\Application\Responses\ExportNewsResponse;

interface ExportNewsActionInterface
{
    public function __invoke(iterable $newsEntities): ExportNewsResponse;
}
