<?php

declare(strict_types=1);

namespace App\App;

use App\Exception\ErrorRequestException;
use App\Request\Request;
use App\Response\Response;
use App\Validation\Validator;
use DomainException;
use Exception;

final class App
{
    public function run(): Response
    {
        try {
            $request = new Request();

            $string = $request->get('string');

            if (!is_string($string) || strlen($string) === 0) {
                throw new DomainException('Invalid request string');
            }

            $validator = new Validator();

            if (!$validator->isValid($string)) {
                throw new ErrorRequestException('Invalid string!');
            }

            $httpCode = 200;
            $responseData['message'] = 'OK';
        } catch (ErrorRequestException $exception) {
            $httpCode = 400;
            $responseData['message'] = $exception->getMessage();
        } catch (Exception) {
            $httpCode = 400;
            $responseData['message'] = 'Error!';
        }

        header('Content-type: application/json; charset=utf-8');
        http_response_code($httpCode);

        return new Response(json_encode($responseData));
    }
}
