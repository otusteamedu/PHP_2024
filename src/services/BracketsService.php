<?php

namespace services;

use dtos\ResponseDto;
use helpers\Brackets;
use Symfony\Component\HttpFoundation\Response;

class BracketsService
{
    private const INCORRECT_MESSAGE = 'String is incorrect';
    private const CORRECT_MESSAGE = 'String is correct';
    private const EMPTY_MESSAGE = 'String is empty';
    private const OPEN_TAG_NO_FOUND = 'Opening bracket not found in the string';

    /**
     * @param Brackets $bracketsHelper
     */
    public function __construct(
        private Brackets $bracketsHelper
    ) {
    }

    /**
     * @param string $str
     * @return ResponseDto
     */
    public function validate(string $str): ResponseDto
    {
        try {
            if (empty($str)) {
                throw new \ErrorException(self::EMPTY_MESSAGE);
            }

            if(strpos($str, $this->bracketsHelper->getOpenBracket()) === false) {
                throw new \ErrorException(self::OPEN_TAG_NO_FOUND);
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

        return new ResponseDto(
            $status,
            $message
        );
    }
}
