<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Actions;

use Exception;
use RailMukhametshin\Hw\Exceptions\HttpException;
use RailMukhametshin\Hw\Requests\StringRequest;

class StringValidatorAction
{
    public function run(StringRequest $request): void
    {
        try {
            if ($request->isPost() === false) {
                throw new HttpException('Method not allowed', 403);
            }

            if ($request->isEmptyString()) {
                throw new HttpException('String is empty');
            }

            if (!$request->isValidString()) {
                throw new HttpException('String is not valid');
            }

            echo json_encode([
                'result' => 'ok',
                'hostname' => $_SERVER['HOSTNAME']
            ]);
        } catch (Exception $exception) {
            http_response_code($exception instanceof HttpException ? $exception->getStatus() : 400);
            echo json_encode([
                'message' => $exception->getMessage()
            ]);
        }
    }
}
