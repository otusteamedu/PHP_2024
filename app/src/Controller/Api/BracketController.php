<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\BracketValidator;

class BracketController
{
    /**
     * @return string
     */
    public function getValidation(): string
    {
        $validationResult = (new BracketValidator())->validate($_POST['string']);

        if ($validationResult) {
            header("HTTP/1.1 200 OK", true, 200);
        } else {
            header("HTTP/1.1 400 BAD REQUEST", true, 400);
        }

        return json_encode(['bracketValidationResult' => $validationResult]);
    }
}
