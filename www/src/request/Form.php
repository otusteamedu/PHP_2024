<?php

namespace Ahor\Hw19\request;

class Form
{
    public string $start;
    public string $end;
    public string $email;

    public function __construct(array $params)
    {
        $this->start = $params['start'] ?? '';
        $this->end = $params['end'] ?? '';
        $this->email = $params['email'] ?? '';
    }

    public function validate(): bool
    {
        return !(empty($this->start) || empty($this->end) || empty($this->email));
    }

}
