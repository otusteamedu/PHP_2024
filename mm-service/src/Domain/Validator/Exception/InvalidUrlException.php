<?php
declare(strict_types=1);

namespace App\Domain\Validator\Exception;

use App\Domain\Exception\InvalidArgumentException;

abstract class InvalidUrlException extends InvalidArgumentException
{
}
