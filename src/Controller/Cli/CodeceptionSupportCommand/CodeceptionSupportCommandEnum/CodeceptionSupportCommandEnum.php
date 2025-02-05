<?php

namespace App\Controller\Cli\CodeceptionSupportCommand\CodeceptionSupportCommandEnum;

enum CodeceptionSupportCommandEnum: string
{
    case CommandMessageShift                  = '                ';
    case CommandMessageSuccess                = 'Success';

    case AbstractCodeceptionSupportCommand    = 'abstract-command';

    case FindAndRemoveTestMessageCommandName  = 'test-message:find-and-remove';
    case FindAndRemoveTestPurchaseCommandName = 'test-purchase:find-and-remove';
    case GetTestPurchaseIdCommandName         = 'test-purchase:get:id';
}
