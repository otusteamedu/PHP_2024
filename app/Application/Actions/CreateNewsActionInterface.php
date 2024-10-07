<?php

namespace App\Application\Actions;

use App\Application\Requests\CreateNewsRequest;
use App\Application\Responses\CreateNewsResponse;

interface CreateNewsActionInterface
{
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse;
}
