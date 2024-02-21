<?php

declare(strict_types=1);

namespace App;

use function Normalizer\normalize;
use function Request\{isPost, post};
use function Response\{prepareBadResponse, prepareGoodResponse};
use function Validator\validateBracketsString;
use function Verification\verifyBrackets;

function runApp(): string
{
    if (!isPost()) {
        return badResponse();
    }

    $string = normalize(post('string', ''));

    if (!validateBracketsString($string)) {
        return badResponse();
    }

    if (!verifyBrackets($string)) {
        return badResponse();
    }

    return goodResponse();
}

function badResponse(): string
{
    prepareBadResponse();

    return 'Bad Request!';
}

function goodResponse(): string
{
    prepareGoodResponse();

    return 'All right!';
}
