<?php

declare(strict_types=1);

namespace App;

use App\Http\Exceptions\BadRequestException;
use App\Http\Request;
use App\Http\Response;
use App\Validators\ParenthesesValidator;
use Exception;

class App
{
    public function run(): string
    {
        $request = new Request();

        try {
            $string = $request->get('string');

            if (empty($string) || !is_string($string)) {
                throw new BadRequestException('The provided input is not a valid string!');
            }

            $parenthesesValidator = new ParenthesesValidator();

            if (!$parenthesesValidator->validate($string)) {
                throw new BadRequestException('Parentheses are invalid!');
            }

            return Response::json(['message' => 'Parentheses are valid!']);
        } catch (BadRequestException $exception) {
            return Response::json(['error' => $exception->getMessage()], $exception->getCode());
        } catch (Exception $exception) {
            return Response::json(['error' => $exception->getMessage()], 500);
        }
    }
}
