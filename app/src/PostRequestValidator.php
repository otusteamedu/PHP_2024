<?php

declare(strict_types=1);

namespace Otus\Hw4;

class PostRequestValidator extends AbstractRequestValidator
{
    /**
     * @var array|string[]
     */
    protected array $allowedMethods = ['POST'];

    /**
     * @param string $requestMethod
     * @param string $postString
     */
    public function __construct(private string $requestMethod, private string $postString)
    {
        $this->validate();
    }

    /**
     * @return void
     */
    protected function validate(): void
    {
        $this->checkRequestMethod();
        $this->checkPostString();
        $this->checkBrackets();
        $this->setResponseParams();
    }

    /**
     * @return void
     */
    private function checkRequestMethod(): void
    {
        if (!in_array($this->requestMethod, $this->allowedMethods)) {
            $this->addError('Invalid request method');
        }
    }

    /**
     * @return void
     */
    private function checkPostString():void
    {
        if (empty($this->postString)) {
            $this->addError('String parameter is empty');
        }
    }

    /**
     * @return void
     */
    private function checkBrackets(): void
    {
        if (!$this->hasOnlyBrackets()) {
            $this->addError("The string must contain only brackets");
        }

        $balance = 0;
        foreach (str_split($this->postString) as $char) {
            if ($char === '(') {
                $balance++;
            } elseif ($char === ')') {
                if ($balance === 0) {
                    $this->addError("Number of opening and closing brackets doesn't match");
                }
                $balance--;
            }
        }
    }

    /**
     * @return int|false
     */
    private function hasOnlyBrackets(): int|false
    {
        return preg_match('/^[()]*$/', $this->postString);
    }
}
