<?php

namespace src\Classes\Validate;

class PostData
{
    protected bool $validateResult = true;
    protected array $post;
    protected  string $string;
    public function __construct(array $post) {
        $this->post = $post;
    }

    /**
     * @throws \Exception
     */
    public function validate(): bool
    {
        $this->checkIncomingParam();
        $this->checkBracketCount();
        return true;
    }

    /**
     * @throws \Exception
     */
    protected function checkIncomingParam(): void
    {
        if(empty($this->post['string'])) {
            throw new \Exception('Param empty');
        }
        $this->string = $this->post['string'];
    }

    /**
     * @throws \Exception
     */
    protected function checkBracketCount(): void
    {
        $arrayOfBrackets = str_split($this->string);

        $countOfOpenBrackets = 0;
        $countOfClosedBrackets = 0;
        if($arrayOfBrackets[0] !== '(' && end($arrayOfBrackets) !== ')' ) {
            throw new \Exception('Wrong string');
        }

        foreach ($arrayOfBrackets as $bracket) {
            if($bracket !== '(' && $bracket !== ')') {
                throw new \Exception('Its not bracket');
            }

            if($bracket === '(') {
                $countOfOpenBrackets++;
            } else {
                $countOfClosedBrackets++;
            }

            if($countOfClosedBrackets > $countOfOpenBrackets) {
                throw new \Exception('Closed brackets more than opened');
            } elseif($countOfClosedBrackets === $countOfOpenBrackets) {
                $countOfOpenBrackets = 0;
                $countOfClosedBrackets = 0;
            }


        }

        if($countOfClosedBrackets !== $countOfOpenBrackets) {
            throw new \Exception('Brackets count is wrong');
        }
    }
}
