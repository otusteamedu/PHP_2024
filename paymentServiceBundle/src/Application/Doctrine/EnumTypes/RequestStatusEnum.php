<?php

namespace PaymentServiceBundle\Application\Doctrine\EnumTypes;

enum RequestStatusEnum: string
{
    case Received  = 'received';
    case Success   = 'processed with success';
    case Error     = 'processed with error: payment was not found';
}

