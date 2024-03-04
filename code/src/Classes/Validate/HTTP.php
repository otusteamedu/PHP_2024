<?php

namespace src\Classes\Validate;

class HTTP
{
    protected array $post;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    /**
     * @throws \Exception
     */
    public function validate(): void
    {
        $this->checkIncomingParam();
    }

    /**
     * @throws \Exception
     */
    protected function checkIncomingParam(): void
    {
        if (empty($this->post['string'])) {
            throw new \Exception('Param empty');
        }
    }
}
