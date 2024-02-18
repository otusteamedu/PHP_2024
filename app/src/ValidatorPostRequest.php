<?php

namespace Dsergei\Hw4;

class ValidatorPostRequest
{
    private const METHOD = 'POST';

    public function __construct(private string $method, private string $value)
    {

    }

    /**
     * @throws \Exception
     */
    public function validate(ICheckerInterface $checker): void
    {
        $this->validateMethod();
        $this->validateData($checker);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function validateMethod(): void
    {
        if ($this->method !== self::METHOD) {
            throw new \Exception('Not valid method. Access only POST method');
        }
    }

    /**
     * @param ICheckerInterface $checker
     * @return void
     */
    private function validateData(ICheckerInterface $checker): void
    {
        $checker->check($this->value);
    }
}
