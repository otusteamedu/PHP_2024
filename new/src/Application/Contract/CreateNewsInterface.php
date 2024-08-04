<?php

namespace Ahar\Hw15\src\Application\Contract;

use Ahar\Hw15\src\Application\Dto\CreateNewsRequest;
use Ahar\Hw15\src\Application\Dto\CreateResponse;

interface CreateNewsInterface
{
    public function handle(CreateNewsRequest $createNewsRequest): CreateResponse;
}
