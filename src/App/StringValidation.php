<?php

namespace VKomar\App;

use Exception;

class StringValidation
{
    /**
     * @return void
     * @throws Exception
     */
    public function checkMethod(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Method Not Allowed');
        }
    }

    /**
     * @param string $string
     * @return void
     * @throws Exception
     */
    public function checkEmpty(string $string = ''): void
    {
        if ($string === '') {
            throw new Exception('Empty string');
        }
    }

    /**
     * @param string $string
     * @return void
     * @throws Exception
     */
    public function checkValid(string $string = ''): void
    {
        if (!preg_match('/[()]/', $string)) {
            throw new Exception('Invalid string');
        }
    }

    /**
     * @return void
     */
    public function checkString(): void
    {
        try {
            $string = $_POST['string'];

            $this->checkMethod();

            $this->checkEmpty($string);

            $this->checkValid($string);

            $stack = [];
            foreach (mb_str_split($string) as $char) {
                if ($char === '(') {
                    $stack[] = $char;
                } elseif ($char === ')') {
                    if (empty($stack)) {
                        throw new Exception('All bad');
                    }
                    array_pop($stack);
                }
            }

            if (!empty($stack)) {
                throw new Exception('All bad');
            }
            $this->response('All good', 200, 'OK');

        } catch (\Exception $exception) {
            $this->response($exception->getMessage());
        }
    }

    private function response($message = '', $code = 400, $status = 'ERROR')
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'code' => $code,
        ]);
    }
}
