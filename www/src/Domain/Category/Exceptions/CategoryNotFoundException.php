<?php

declare(strict_types=1);

namespace App\Domain\Category\Exceptions;

use App\Domain\DomainException\DomainRecordNotFoundException;

class CategoryNotFoundException extends DomainRecordNotFoundException
{

}