<?php

namespace Ahor\Hw19\response;

enum ResponseStatus: int
{
    case OK = 200;
    case BAD_REQUEST = 400;
}
