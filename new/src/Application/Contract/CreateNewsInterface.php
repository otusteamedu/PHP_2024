<?php

namespace Ahar\hw15\src\Application\Contract;

use Ahar\hw15\src\Application\Dto\CreateNewsRequest;
use Ahar\hw15\src\Application\Dto\CreateResponse;

interface CreateNewsInterface
{
    public function handle(CreateNewsRequest $createNewsRequest): CreateResponse;
}
