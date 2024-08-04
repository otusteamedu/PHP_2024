<?php

namespace Ahar\hw15\src\Application\Contract;

use Ahar\hw15\src\Application\Dto\UpdateNewsRequest;
use Ahar\hw15\src\Application\Dto\UpdateResponse;

interface UpdateNewsInterface
{
    public function handle(UpdateNewsRequest $updateNewsRequest): UpdateResponse;
}
