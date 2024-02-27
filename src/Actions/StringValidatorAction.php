<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Actions;

use Exception;
use RailMukhametshin\Hw\Exceptions\HttpException;
use RailMukhametshin\Hw\Requests\StringRequest;

class StringValidatorAction
{
    private StringRequest $request;

    public function __construct()
    {
        $this->request = new StringRequest();
    }
    public function run(): string
    {
        try {
            if ($this->request->isPost() === false) {
                throw new HttpException('Method not allowed', 403);
            }

            if ($this->request->isEmptyString()) {
                throw new HttpException('String is empty');
            }

            if (!$this->request->isValidString()) {
                throw new HttpException('String is not valid');
            }

            return json_encode([
                'result' => 'ok',
                'hostname' => $_SERVER['HOSTNAME']
            ]);
        } catch (Exception $exception) {
            http_response_code($exception instanceof HttpException ? $exception->getStatus() : 400);
            return json_encode([
                'message' => $exception->getMessage()
            ]);
        }
    }
}
