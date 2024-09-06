<?php

declare(strict_types=1);

namespace App\App;

use function App\Request\{isPost, post};
use function App\Validate\isValidString;

function runApp(): string
{
    if (!isPost()) {
        http_response_code(405);

        return 'Method Not Allowed';
    }

    $string = post('string');

    if (empty($string)) {
        http_response_code(400);

        return 'The [string] cannot be empty';
    }

    if (isValidString($string)) {
        http_response_code(200);

        return 'OK';
    }

    http_response_code(400);

    return 'The [string] is not a valid';
}
