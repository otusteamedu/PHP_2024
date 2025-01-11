<?php

namespace App\Infrastructure\Entity;

enum StatusEnum: string
{
    case Requested = "REQUESTED";
    case Processing = "PROCESSING";
    case Done = "DONE";

    case Error = "ERROR";

}
