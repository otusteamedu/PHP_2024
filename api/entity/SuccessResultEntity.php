<?php

declare(strict_types=1);

namespace api\entity;

use api\form\MockErrorFormResponse;
use JetBrains\PhpStorm\Pure;

class SuccessResultEntity extends ResultEntity
{
    #[Pure]
 public function __construct($result)
 {
     parent::__construct($result, new MockErrorFormResponse());
 }
}
