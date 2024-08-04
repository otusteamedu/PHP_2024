<?php

namespace Ahar\Hw15\src\Application\Contract;

use Ahar\Hw15\src\Application\Dto\UpdateNewsRequest;
use Ahar\Hw15\src\Application\Dto\UpdateResponse;

interface UpdateNewsInterface
{
    public function handle(UpdateNewsRequest $updateNewsRequest): UpdateResponse;
}
