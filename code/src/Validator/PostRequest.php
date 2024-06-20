<?php
declare(strict_types=1);

namespace App\Validator;

use App\Request\Request;

class PostRequest implements ValidatorInterface
{
    const string REQUEST_METHOD_POST = 'POST';

    /** @var mixed  */
    protected mixed $data;

    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->data instanceof Request
            && $this->data->getMethod() === self::REQUEST_METHOD_POST;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return 'Allow only POST requests';
    }
}
