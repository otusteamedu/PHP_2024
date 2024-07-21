<?php

declare(strict_types=1);

namespace api\entity;

use api\contracts\ErrorFormResponseInterface;
use JetBrains\PhpStorm\Pure;

class ErrorResultEntity extends ResultEntity
{
    #[Pure]
 public function __construct(ErrorFormResponseInterface $errorFormResponse)
 {
     parent::__construct([], $errorFormResponse);
 }
}
