<?php

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
     * @param string $string
     * @return bool|string
     * @throws Exception
     */
    public function checkString(string $string = ''): bool|string
    {
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

        if (empty($stack)) {
            http_response_code(200);

            return json_encode([
                'status' => 'OK',
                'message' => 'All good',
                'code' => 200,
            ]);
        }

        throw new Exception('All bad');
    }
}
