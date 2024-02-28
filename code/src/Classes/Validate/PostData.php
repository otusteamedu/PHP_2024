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
        $bracketsCountOpen = mb_substr_count($this->string,'(');
        $bracketsCountClose = mb_substr_count($this->string,')');

        if(($bracketsCountOpen !== $bracketsCountClose) || ($bracketsCountOpen === 0 || $bracketsCountClose === 0)) {
            throw new \Exception('Wrong brackets count');
        }
    }
}
