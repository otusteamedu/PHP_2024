<?php

namespace services;

use helpers\Brackets;
use Symfony\Component\HttpFoundation\Response;

class BracketsService
{
    private const INCORRECT_MESSAGE = 'String is incorrect';
    private const CORRECT_MESSAGE = 'String is correct';
    private const EMPTY_MESSAGE = 'String is empty';

    /**
     * @param Brackets $bracketsHelper
     */
    public function __construct(
        private Brackets $bracketsHelper
    ) {
    }

    /**
     * @param string $str
     * @return Response
     */
    public function validate(string $str): Response
    {
        try {
            if (empty($str)) {
                throw new \ErrorException(self::EMPTY_MESSAGE);
            }

            if (!$this->bracketsHelper->validate($str)) {
                throw new \ErrorException(self::INCORRECT_MESSAGE);
            }

            $status = Response::HTTP_OK;
            $message = self::CORRECT_MESSAGE;
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            $status = Response::HTTP_BAD_REQUEST;
        }

        $response = new Response(
            $message,
            $status,
            ['content-type' => 'text/html']
        );

        return $response->send();
    }
}
