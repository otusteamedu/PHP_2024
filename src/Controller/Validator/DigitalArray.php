<?php

namespace App\Controller\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class DigitalArray extends Constraint
{
    /**
     * @var string $message
     */
    public $message = 'Element(s) of array {{ value }} is(are) not a number';
}
