<?php

namespace App\Controller\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UniqueUrl extends Constraint
{
    /**
     * @var string $message
     */
    public $message = 'Url {{ value }} already exists';
}
